<?php

namespace BonsaiForm\Module;

use \Bonsai\Module\Registry as CoreRegistry;
use \Bonsai\Module\Tools;
use \Bonsai\Leaf;

class Validate
{
    public static function validateField ($field, $value, &$responses = null) {
        
        if ( $responses == null )
        {
          $responses = array();
        }
        
        $data = Leaf::getContentDataArray($field);
        
        if (is_null($data) || !is_array($data)){
            return null;
        }

        if (!isset($data['validators'])){
            return $responses;
        }       
        
        foreach ($data['validators'] as $validator){
            if (!isset($validator['validator'])){
                CoreRegistry::log($message, __FILE__, __METHOD__, __LINE__);
            }
            
            $validatorClass = CoreRegistry::resolveClass('validator', $validator['validator'], '\\Validator');
            
            if ($validatorClass && Tools::class_implements($validatorClass, 'BonsaiForm\Validator\Validator')) {
                $validatorObject = new $validatorClass($validator);
                $validation = $validatorObject->validate($value);
                
                if (!is_null($validation)){
                    $responses[$field][] = $validation;
                }
            }
        }
            
        return $responses;
    }
    
    public static function validateSet ($fields, &$responses = null) {
        
        if ( $responses == null )
        {
          $responses = array();
        }
        
        foreach ($fields as $field => $value){
            static::validateField($field, $value, $responses);
        }
        
        return $responses;
    }    
}
