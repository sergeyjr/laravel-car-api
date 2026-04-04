<?php

use Illuminate\Support\Facades\Route;
use Modules\API\V1\Http\Controllers\ApiAuthController;
use Modules\API\V1\Http\Controllers\CarController;
use Modules\API\V1\Routes\RoutePaths;

Route::prefix('v1')->group(function () {

    // Авторизация пользователя
    Route::post('/auth/login', [ApiAuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'api.role'])->group(function () {

        Route::prefix('car')->group(function () {

            // Получение списка машин
            Route::get('/', [CarController::class, 'index']);

            // Получение машины по ID
            Route::get(RoutePaths::ID, [CarController::class, 'show']);

            // Создание машины
            Route::post('/', [CarController::class, 'create']);

            // Обновление машины (полное)
            Route::put(RoutePaths::ID, [CarController::class, 'update']);

            // Обновление машины (частичное)
            Route::patch(RoutePaths::ID, [CarController::class, 'update']);

            // Удаление машины
            Route::delete(RoutePaths::ID, [CarController::class, 'destroy']);

            // Генерация тестовых данных для создания машины
            Route::get('/generate-mock', [CarController::class, 'generateMock']);

        });

    });

});
