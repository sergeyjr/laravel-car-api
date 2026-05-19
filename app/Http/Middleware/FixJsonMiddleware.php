<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FixJsonMiddleware
{

    public function handle(Request $request, Closure $next)
    {

        if ($request->isJson()) {
            $content = $request->getContent();
            if (!empty($content)) {
                $fixed = preg_replace('/,\s*(?=[}\]])/', '', $content);
                $decoded = json_decode($fixed, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $request->replace($decoded);
                }
            }
        }

        return $next($request);

    }

}
