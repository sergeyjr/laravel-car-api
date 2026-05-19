<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{

    protected function redirectTo($request): ?string
    {
        // \vendor\laravel\framework\src\Illuminate\Foundation\Exceptions\Handler.php
        // protected function unauthenticated
        // Route [login] not defined
        // отключаем редирект на login
        return null;
    }

}
