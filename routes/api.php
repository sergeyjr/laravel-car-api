<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CarController;

// API
Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login'])
        ->middleware('auth.flex:none');
    });

    Route::prefix('car')
        ->middleware('auth.flex:auto') // используется значение AUTH_MODE в .env
        ->group(function () {
            Route::post('/create', [CarController::class, 'create']);
            Route::get('/list', [CarController::class, 'list']);
            Route::get('/{id}', [CarController::class, 'view'])
                ->where('id', '[0-9]+');
        });

});
