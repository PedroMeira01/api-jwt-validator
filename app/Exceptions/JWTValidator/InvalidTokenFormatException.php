<?php

namespace App\Exceptions\JWTValidator;

use Exception;

class InvalidTokenFormatException extends Exception
{
    protected $message = "The token sent is incompatible with the JWT format.";
}