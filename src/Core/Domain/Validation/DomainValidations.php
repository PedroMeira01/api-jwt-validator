<?php

declare(strict_types=1);

namespace Core\Domain\Validation;

use App\Exceptions\EntityValidationException;

class DomainValidations {

    public static function strMaxLength(string $value, int $maxLength = 255, $message = null)
    {
        if (strlen($value) > $maxLength)
            throw new EntityValidationException($message ?? "Value can be a maximum of 255 characters.");
    }

    public static function hasNumericChars(string $value, $message = null)
    {
        if (preg_match('/[0-9]/', $value)) {
            throw new EntityValidationException($message ?? "Value must not contain numeric characters.");
        }
    }

    public static function isPrimeNumber($number, $message = null)
    {
        $error = new EntityValidationException($message ?? 'Value must be a prime number.');

        if ($number == 1) 
            throw $error;

        for ($i = 2; $i <= $number/2; $i++) {
            if ($number % $i == 0)
                throw $error;
        }
    }

}