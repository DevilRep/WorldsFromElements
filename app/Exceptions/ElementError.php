<?php

namespace App\Exceptions;

use Throwable;

class ElementError extends ApplicationError
{
    public function __construct($element, $message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct(str_replace('%element%', $element, $message), $code, $previous);
    }
}