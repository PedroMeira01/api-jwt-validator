<?php

declare(strict_types=1);

use App\Http\Controllers\API\TokenValidatorController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], static function () {
    Route::post('validation', [TokenValidatorController::class, 'validateJWT']);
});