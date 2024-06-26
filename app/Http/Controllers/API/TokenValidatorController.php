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
        try {
            $response = $useCase->execute(new InputValidateTokenDTO(
                token: $request->input('token')
            ));

            return response()->json(new TokenValidatorResource($response), 200);
        } catch (\Throwable $th) {
            return response()->json(new TokenValidatorResource((object) [
                'isValid' => false,
                'message' => $th->getMessage()
            ]), 422);
        }
    }
}
