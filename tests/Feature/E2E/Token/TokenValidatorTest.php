<?php

namespace Tests\Feature;

use Tests\TestCase;

class TokenValidatorTest extends TestCase
{

    private string $endpoint = '/api/v1/token-validation';

    public function test_jwt_validation_successfull(): void
    {
        $response = $this->postJson($this->endpoint."/jwt", [
            'token' => "eyJhbGciOiJIUzI1NiJ9.".
            "eyJSb2xlIjoiQWRtaW4iLCJTZWVkIjoiNzg0MSIsIk5hbWUiOiJUb25pbmhvIEFyYXVqbyJ9.".
            "QY05sIjtrcJnP533kQNk8QXcaleJ1Q01jWY_ZzIZuAg"
        ]);

        $response->assertJsonStructure(['isValid']);
        $response->assertStatus(200);
    }

    /**
     * @dataProvider dataProviderInvalidJWT
     */
    public function test_jwt_validation_exceptions(
        string $token,
        int $code
    ): void
    {
        $response = $this->postJson($this->endpoint."/jwt", [
            'token' => $token
        ]);

        $response->assertStatus($code);
    }

    public static function dataProviderInvalidJWT(): array
    {
        return [
            [
                'token' => "eyJhbGciOiJzI1NiJ9.".
                "dfsdfsfryJSr2xrIjoiQWRtaW4iLCJTZrkIjoiNzg0MSIsIk5hbrUiOiJUb25pbmhvIEFyYXVqbyJ9.".
                "QY05fsdfsIjtrcJnP533kQNk8QXcaleJ1Q01jWY_ZzIZuAg",
                'code' => 422,
            ], [
                'token' => "eyJhbGciOiJIUzI1NiJ9.".
                "eyJSb2xlIjoiRXh0ZXJuYWwiLCJTZWVkIjoiODgwMzciLCJOYW1lIjoiTTRyaWEgT2xpdmlhIn0.".
                "6YD73XWZYQSSMDf6H0i3-kylz1-TY_Yt6h1cV2Ku-Qs",
                'code' => 422
            ], [
                'token' => "eyJhbGciOiJIUzI1NiJ9.".
                "eyJSb2xlIjoiTWVtYmVyIiwiT3JnIjoiQlIiLCJTZWVkIjoiMTQ2MjciLCJOYW1lIjoiVmFsZGlyIEFyYW5oYSJ9.".
                "cmrXV_Flm5mfdpfNUVopY_I2zeJUy4EZ4i3Fea98zvY",
                "code" => 422
            ]
        ];
    }
}
