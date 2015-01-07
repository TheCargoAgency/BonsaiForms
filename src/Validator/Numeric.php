<?php

namespace BonsaiForm\Validator;

class Numeric implements Validator
{

    public function __construct($options)
    {
    }
    
    public function validate($value)
    {
        return is_numeric($value) ? null : 'The value must be numeric.';
    }
}
