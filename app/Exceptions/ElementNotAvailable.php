<?php

namespace App\Exceptions;

class ElementNotAvailable extends ElementError
{
    protected $message = 'The element %element% does not available for you';
}