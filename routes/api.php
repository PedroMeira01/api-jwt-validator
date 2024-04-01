<?php

declare(strict_types=1);

use App\Http\Controllers\API\TokenValidatorController;
use App\Http\Middleware\TokenMiddleware;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], static function () {
    Route::post('token-validation/jwt', [TokenValidatorController::class, 'validateJWT'])->middleware(TokenMiddleware::class);
});