<?php

namespace App\Exceptions\JWTValidator;

use Exception;

class InvalidClaimsException extends Exception
{
    protected $message = "Claims must only contain the keys: Name, Seed and Role";
}