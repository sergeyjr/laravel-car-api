<?php

use Illuminate\Support\Facades\Route;
use Modules\API\V1\Http\Controllers\CarController;
use Modules\API\V1\Http\Controllers\ApiAuthController;

Route::prefix('v1')->group(function () {

    Route::post('/auth/login', [ApiAuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'api.role'])->group(function () {
        Route::prefix('car')->group(function () {
            Route::post('/create', [CarController::class, 'create']);
            Route::get('/list', [CarController::class, 'list']);
            Route::get('/{id}', [CarController::class, 'view']);
            Route::get('/generate-mock', [CarController::class, 'generateMock']);
        });
    });

});
