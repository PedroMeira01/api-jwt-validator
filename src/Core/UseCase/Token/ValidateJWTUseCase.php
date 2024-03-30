<?php

declare(strict_types=1);

namespace Core\UseCase\Token;

use Core\Domain\Entity\JWT;
use Core\UseCase\Token\DTO\InputValidateTokenDTO;
use Core\UseCase\Token\DTO\OutputValidateTokenDTO;

class ValidateJWTUseCase {

    public function execute(InputValidateTokenDTO $input): OutputValidateTokenDTO
    {
        $token = new JWT(
            token: $input->token
        );

        $token->isValid();

        return new OutputValidateTokenDTO(isValid: $token->isValid());
    }
    
}