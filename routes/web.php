<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

// DDD
//use App\Http\Controllers\Web\AuthController;
//use App\Http\Controllers\Web\FileController;
//use Illuminate\Support\Facades\Redis;
//use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/files/{path}', [FileController::class, 'show'])
    ->where('path', '.*');

Route::get('/test-redis', function () {
    Redis::set('test', 'hello');
    return Redis::get('test');
});

Route::view('/{any}', 'layouts.app')
    ->where('any', '^(?!api|sanctum).*$');
