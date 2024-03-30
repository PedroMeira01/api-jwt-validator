<?php

declare(strict_types=1);

namespace Core\Domain\Entity;

use App\Exceptions\JWTValidator\InvalidClaimsException;
use App\Exceptions\JWTValidator\InvalidTokenFormatException;

class JWT {

    const ALLOWED_CLAIMS = ['Name', 'Seed', 'Role'];

    protected Claims $claims;

    protected bool $isValid = false;

    public function __construct(protected string $token) {
        $this->validate();
    }

    private function validate()
    {
        $token = explode('.', $this->token);

        if (count($token) === 3) {

            $decodedToken = $this->decrypt($token[1]);
            
            if ($claims = $this->hasAllowedClaims($decodedToken)) {

                $this->claims = new Claims(
                    name: $claims['Name'],
                    seed: (int) $claims['Seed'],
                    role: $claims['Role']
                );

                $this->isValid = true;

                return;
            }
        }

        throw new InvalidTokenFormatException();
    }

    public function decrypt(string $token): string
    {
        return base64_decode(str_replace('_', '/', str_replace('-','+', $token)));
    }

    public function hasAllowedClaims(string $decodedToken): array|false
    {
        $receivedClaims = json_decode($decodedToken, true);
            
        $isValidClaims = collect($receivedClaims)
                            ->keys()->intersect(self::ALLOWED_CLAIMS)
                            ->count() === count($receivedClaims);
        
        if (!$isValidClaims) {
            throw new InvalidClaimsException();   
        }

        return $receivedClaims;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }
}
