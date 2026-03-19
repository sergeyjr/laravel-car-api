<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CarController;

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::prefix('car')->group(function () {

        Route::post('/create', [CarController::class, 'create']);

        Route::get('/list', [CarController::class, 'list']);

        Route::get('/{id}', [CarController::class, 'view'])
            ->where('id', '[0-9]+');

    });

});
