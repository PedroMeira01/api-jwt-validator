<?php

namespace App\Exceptions;

use App\Exceptions\JWTValidator\InvalidClaimsException;
use App\Exceptions\JWTValidator\InvalidTokenFormatException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof EntityValidationException)
            return $this->showError($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        
        if ($exception instanceof InvalidTokenFormatException) {
            return $this->showError($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($exception instanceof InvalidClaimsException) {
            return $this->showError($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return parent::render($request, $exception);
    }

    private function showError(string $message, int $statusCode)
    {
        return response()->json([
            'message' => $message
        ], $statusCode);
    }
}
