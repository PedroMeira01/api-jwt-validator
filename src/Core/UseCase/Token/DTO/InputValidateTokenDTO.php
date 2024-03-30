<?php

declare(strict_types=1);

namespace Core\UseCase\Token\DTO;

class InputValidateTokenDTO {
    public function __construct(
        public string $token
    ) {}
}