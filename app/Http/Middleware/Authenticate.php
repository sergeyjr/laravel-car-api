<?php

namespace App\Http\Middleware;

class Authenticate
{

    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return null;
        }
        return route('login');
    }

}
