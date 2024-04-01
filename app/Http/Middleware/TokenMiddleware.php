<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TokenMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('O token enviado pelo cliente: '.$request->input('token', ''));

        return $next($request);
    }

    public function terminate($request, $response)
    {
        Log::info('A requisição gerou a seguinte resposta: ' . $response->getContent());
    }
}
