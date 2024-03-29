<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\JWTValidatorRole;
use App\Exceptions\EntityValidationException;
use App\Exceptions\JWTValidator\InvalidClaimsException;
use App\Exceptions\JWTValidator\InvalidTokenFormatException;

class JWTValidatorService {

    public function validation(string $token): bool
    {

        ['Role' => $role, 'Name' => $name,'Seed' => $seed] = $this->validateTokenFormat($token);

        return $this->validateClaims($role, (int) $seed, $name);        
    }

    private function validateTokenFormat(string $token): array
    {
        $token = explode('.', $token);

        if (count($token) === 3) {

            $decodedToken = base64_decode(str_replace('_', '/', str_replace('-','+', $token[1])));

            if ($claims = json_decode($decodedToken, true)) {
                
                $keys = ['Name', 'Seed', 'Role'];

                $validClaims = collect($claims)->keys()->intersect($keys)->count() === count($claims);
                
                if (!$validClaims) {
                    throw new InvalidClaimsException();   
                }

                return $claims;

            }
        }

        throw new InvalidTokenFormatException();
    }

    private function validateClaims(string $role, int $seed, string $name): bool
    {
        if (strlen($name) > 256 || preg_match('/[0-9]/', $name)) {
            throw new EntityValidationException(
                "The name parameter must contain a maximum of 256 characters ".
                'and must not contain numeric characters.'
            );
        }

        if (is_null(JWTValidatorRole::tryFrom($role))) {
            throw new EntityValidationException(
                'The role parameter must have one of the following values: Admin, Member, External.'
            );
        }

        if (!$this->isPrimeNumber($seed)) {
            throw new EntityValidationException('The seed parameter must be a prime number.');
        }

        return true;
    }

    private function isPrimeNumber(int $number): bool
    {
        if ($number == 1) {
            return false;
        }

        for ($i = 2; $i <= $number/2; $i++) {
            if ($number % $i == 0) {
                return false;
            }
        }

        return true;
    }
}