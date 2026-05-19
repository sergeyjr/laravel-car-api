<?php

namespace App\Http\Middleware;

use Closure;

class EnsureApiRole
{

    public const UNAUTHORIZED = 'Требуется авторизация.';
    public const FORBIDDEN = 'Доступ запрещен.';

    public function handle($request, Closure $next)
    {

        $user = auth('sanctum')->user();

        if (!$user) {
            return response()->json([
                'message' => self::UNAUTHORIZED
            ], 401, [], JSON_UNESCAPED_UNICODE);
        }

        if ($user->role !== 'api') {
            return response()->json([
                'message' => self::FORBIDDEN
            ], 403, [], JSON_UNESCAPED_UNICODE);
        }

        return $next($request);

    }

}
