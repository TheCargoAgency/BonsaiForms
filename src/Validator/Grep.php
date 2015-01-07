<?php

namespace BonsaiForm\Validator;

class Grep implements Validator
{
    protected $pattern;
    protected $mode;
    
    public function __construct($options)
    {
        $this->mode = isset($options->mode) && in_array($options->mode, ['contains','starts','ends','is']) ? $options->mode : 'contains';
        
        switch ($this->mode){
            case 'starts':
                $this->pattern = "/^{$this->pattern}/";
                continue;
            case 'ends':
                $this->pattern = "/{$this->pattern}$/";
                continue;
            case 'is':
                $this->pattern = "/^{$this->pattern}$/";
                continue;
            default :
                $this->pattern = "/{$this->pattern}/";
        }
        
        $this->pattern = isset($options->pattern) ? $options->pattern : '.+';
        
        $this->message = isset($options->message) ? $options->message : 'The value does not match the pattern.';
    }
    
    public function validate($value)
    {
        return preg_match($this->pattern, $value) ? null : $this->message;
    }
}
