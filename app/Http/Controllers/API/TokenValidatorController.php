<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TokenValidatorRequest;
use App\Http\Resources\TokenValidatorResource;
use Core\UseCase\Token\DTO\InputValidateTokenDTO;
use Core\UseCase\Token\ValidateJWTUseCase;
use Illuminate\Http\JsonResponse;

class TokenValidatorController extends Controller
{    
    public function validateJWT(TokenValidatorRequest $request, ValidateJWTUseCase $useCase): JsonResponse
    {
        $response = $useCase->execute(new InputValidateTokenDTO(
            token: $request->input('token')
        ));

        return response()->json(new TokenValidatorResource(['isValid' => $response->isValid]), 200);
    }
}
