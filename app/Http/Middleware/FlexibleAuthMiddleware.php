<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Helpers\ApiResponse;

class FlexibleAuthMiddleware
{

    public function handle(Request $request, Closure $next, ...$params)
    {

        $mode = $params[0] ?? 'any';

        // авто-режим из .env
        if ($mode === 'auto') {
            $mode = config('app.auth_mode', 'any');
        }

        if ($mode === 'none') {
            return $next($request);
        }

        $apiKey = $request->header('X-API-KEY');
        $tokenHeader = $request->header('Authorization');

        $token = null;
        if ($tokenHeader && str_starts_with($tokenHeader, 'Bearer ')) {
            $token = substr($tokenHeader, 7);
        }

        $validApiKey = $apiKey && $apiKey === config('app.api_key');
        $validToken = $token && $this->checkToken($token);

        switch ($mode) {
            case 'apikey':
                if (!$validApiKey) {
                    return ApiResponse::error('Invalid API key', 401);
                }
                break;

            case 'token':
                if (!$validToken) {
                    return ApiResponse::error('Invalid token', 401);
                }
                break;

            case 'any':
                if (!$validApiKey && !$validToken) {
                    return ApiResponse::error('Unauthorized', 401);
                }
                break;
        }

        return $next($request);
    }

    private function checkToken(string $token): bool
    {
        return app(AuthService::class)->check($token);
    }

}
