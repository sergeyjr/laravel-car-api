<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Modules\API\V1\Http\Middleware\FlexibleAuthMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withExceptions(function ($exceptions) {
        $exceptions->render(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return new JsonResponse([
                    'success' => false,
                    'errors' => 'Unauthenticated'
                ], 401);
            }
            return redirect()->route('login');
        });
        $exceptions->render(function (\Throwable $e, $request) {
            if ($request->expectsJson()) {
                return new JsonResponse([
                    'success' => false,
                    'data' => null,
                    'errors' => $e->getMessage(),
                    'trace' => config('app.debug') ? $e->getTraceAsString() : null,
                ], 500);
            }
            return null;
        });
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.flex' => FlexibleAuthMiddleware::class,
        ]);
    })
    ->create();
