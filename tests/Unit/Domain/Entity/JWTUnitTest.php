<?php

namespace Tests\Unit;

use App\Exceptions\JWTValidator\InvalidClaimsException;
use App\Exceptions\JWTValidator\InvalidTokenFormatException;
use Core\Domain\Entity\JWT;
use PHPUnit\Framework\TestCase;

class JWTUnitTest extends TestCase
{
    protected string $token = "eyJhbGciOiJIUzI1NiJ9.".
    "eyJSb2xlIjoiQWRtaW4iLCJTZWVkIjoiNzg0MSIsIk5hbWUiOiJUb25pbmhvIEFyYXVqbyJ9.".
    "QY05sIjtrcJnP533kQNk8QXcaleJ1Q01jWY_ZzIZuAg";

    public function test_jwt()
    {        
        $jwt = new JWT(
            token: $this->token
        );

        $this->assertEquals($this->token, $jwt->token);
        $this->assertNotEmpty($jwt->claims);
        $this->assertEquals(true, $jwt->isValid);
    }

    public function test_validate_with_invalid_token()
    {
        $this->expectException(InvalidTokenFormatException::class);

        $token = "Token inválido";

        $jwt = new JWT(
            token: $token
        );
    }

    public function test_validate_with_invalid_claims()
    {
        $this->expectException(InvalidClaimsException::class);

        $token = "eyJhbGciOiJIUzI1NiJ9.".
        "eyJSb2xlIjoiTWVtYmVyIiwiT3JnIjoiQlIiLCJTZWVkIjoiMTQ2MjciLCJOYW1lIjoiVmFsZGlyIEFyYW5oYSJ9.".
        "cmrXV_Flm5mfdpfNUVopY_I2zeJUy4EZ4i3Fea98zvY";

        $jwt = new JWT(
            token: $token
        );
    }

    public function test_decrypt()
    {
        $jwt = new JWT(
            token: $this->token
        );
        $output = (string) $jwt->decrypt($this->token);

        $this->assertNotEmpty($output);
    }
}
