<?php

namespace Tests\Feature;

use Core\UseCase\Token\DTO\InputValidateTokenDTO;
use Core\UseCase\Token\DTO\OutputValidateTokenDTO;
use Core\UseCase\Token\ValidateJWTUseCase;
use Tests\TestCase;

class ValidateJWTUseCaseTest extends TestCase
{

    public function test_validate_jwt_use_case(): void
    {
        $input = new InputValidateTokenDTO(
            token: "eyJhbGciOiJIUzI1NiJ9.".
            "eyJSb2xlIjoiQWRtaW4iLCJTZWVkIjoiNzg0MSIsIk5hbWUiOiJUb25pbmhvIEFyYXVqbyJ9.".
            "QY05sIjtrcJnP533kQNk8QXcaleJ1Q01jWY_ZzIZuAg"
        );

        $useCase = new ValidateJWTUseCase();
        $response = $useCase->execute($input);

        $this->assertTrue($response->isValid);
        $this->assertInstanceOf(OutputValidateTokenDTO::class, $response);
    }
}
