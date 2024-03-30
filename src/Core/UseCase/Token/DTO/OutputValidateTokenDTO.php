<?php

declare(strict_types=1);

namespace Core\UseCase\Token\DTO;

class OutputValidateTokenDTO {
    public function __construct(
        public bool $isValid
    ) {}
}