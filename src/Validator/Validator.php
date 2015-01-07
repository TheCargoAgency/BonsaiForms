<?php

namespace BonsaiForm\Validator;

interface Validator
{
    public function __construct($options);
    public function Validate($value); //return string null
}
