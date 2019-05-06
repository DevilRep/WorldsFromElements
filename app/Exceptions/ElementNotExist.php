<?php

namespace App\Exceptions;

class ElementNotExist extends ElementError
{
    protected $message = 'Component %element% does not exist';
}