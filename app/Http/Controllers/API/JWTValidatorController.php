<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\JWTValidatorRequest;
use App\Http\Resources\JWTValidatorResource;
use App\Services\JWTValidatorService;
use Illuminate\Http\JsonResponse;

class JWTValidatorController extends Controller
{
    public function __construct(
        protected JWTValidatorService $service
    ) {}
    
    public function validation(JWTValidatorRequest $request): JsonResponse
    {
        $output = $this->service->validation($request->input('token'));
        
        return response()->json(new JWTValidatorResource(['isValid' => $output]), 200);
    }
}
