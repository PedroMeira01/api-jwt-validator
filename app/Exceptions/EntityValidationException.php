<?php

namespace App\Exceptions;

use Exception;

class EntityValidationException extends Exception
{
    protected $message = "Invalid parameter.";
}