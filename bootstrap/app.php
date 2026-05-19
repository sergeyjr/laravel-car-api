<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\EnsureApiRole;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withExceptions(function ($exceptions) {

        // Auth errors
        $exceptions->render(function (AuthenticationException $e, $request) {
            $hasToken = $request->bearerToken();
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => $hasToken
                    ? 'Неверный или истекший токен. Получите новый.'
                    : 'Требуется авторизация. (APP)',
            ], 401);
        });

        // Validation errors
        $exceptions->render(function (ValidationException $e, $request) {
            return response()->json([
                'success' => false,
                'data' => null,
                'errors' => $e->errors(),
            ], 422);
        });

        // Throttle errors
        $exceptions->render(function (ThrottleRequestsException $e, $request) {
            $retryAfter = $e->getHeaders()['Retry-After'] ?? null;
            return response()->json([
                'success' => false,
                //'message' => 'Слишком много попыток. Попробуйте позже.',
                'retry_after' => $retryAfter,
            ], 429);
        });

        // Forbidden
        $exceptions->render(function (HttpException $e, $request) {

            if ($e->getStatusCode() === 403) {
                return response()->json([
                    'success' => false,
                    'data' => null,
                    'message' => 'Доступ запрещен.',
                ], 403);
            }

            if ($e->getStatusCode() === 404 && $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Не найдено.',
                ], 404);
            }

            return null;
        });

        // Fallback error
//        $exceptions->render(function (\Throwable $e, $request) {
//            if ($request->is('api/*')) {
//                return response()->json([
//                    'success' => false,
//                    'message' => 'Внутренняя ошибка сервера.',
//                ], 500);
//            }
//            return null;
//        });

    })
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'api.role' => EnsureApiRole::class,
            'guest' => RedirectIfAuthenticated::class,
            'auth' => Authenticate::class,
        ]);

    })
    ->create();
