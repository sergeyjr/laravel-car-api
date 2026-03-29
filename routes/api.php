<?php

use Illuminate\Support\Facades\Route;
use Modules\API\V1\Http\Controllers\AuthController;
use Modules\API\V1\Http\Controllers\CarController;

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login'])
            ->middleware('auth.flex:none');
    });

    Route::prefix('car')
        ->middleware('auth.flex:auto')
        ->group(function () {
            Route::post('/create', [CarController::class, 'create']);
            Route::get('/list', [CarController::class, 'list']);
            Route::get('/{id}', [CarController::class, 'view'])
                ->where('id', '[0-9]+');
        });

});
