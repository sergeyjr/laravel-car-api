<?php

namespace App\Http\Middleware;

use Closure;

class EnsureApiRole
{

    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if (!$user || $user->role !== 'api') {
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }

        return $next($request);
    }

}
