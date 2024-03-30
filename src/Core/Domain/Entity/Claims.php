<?php

declare(strict_types=1);

namespace Core\Domain\Entity;

use App\Exceptions\EntityValidationException;
use Core\Domain\Enums\JWTRoleEnum;
use Core\Domain\Validation\DomainValidations;

class Claims {

    public function __construct(
        protected string $name,
        protected int $seed,
        protected string $role
    ) {
        $this->validate();
    }

    private function validate() {

        DomainValidations::strMaxLength($this->name, 256, "Name must contain a maximum of 256 characters.");
        DomainValidations::hasNumericChars($this->name, "Name must not contain numeric characters");
        
        DomainValidations::isPrimeNumber($this->seed, "Seed must be a prime number.");

        if (!JWTRoleEnum::tryFrom($this->role)) {
            throw new EntityValidationException(
                'Role must have one of the following values: Admin, Member, External.'
            );
        }

    }
}
