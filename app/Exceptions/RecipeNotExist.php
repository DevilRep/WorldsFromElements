<?php

namespace App\Exceptions;

class RecipeNotExist extends RecipeError
{
    protected $message = 'Recipe with selected components does not exist';
}