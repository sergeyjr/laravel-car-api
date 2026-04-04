<?php

use Illuminate\Support\Facades\Route;
use Modules\API\V1\Http\Controllers\ApiAuthController;
use Modules\API\V1\Http\Controllers\CarController;
use Modules\API\V1\Routes\RoutePaths;

Route::prefix('v1')->group(function () {

    // Авторизация пользователя
    Route::post('/auth/login', [ApiAuthController::class, 'login']);

    // Доступ к api есть только у пользователей с ролью "api"
    Route::middleware(['auth:sanctum', 'api.role'])->group(function () {

        Route::prefix('car')->group(function () {

            // Получение списка машин
            Route::get('/list', [CarController::class, 'list']);

            // Получение машины по ID
            Route::get(RoutePaths::ID, [CarController::class, 'show']);

            // Создание машины
            Route::post('/create', [CarController::class, 'create']);

            // Обновление машины (полное)
            Route::put('/update' . RoutePaths::ID, [CarController::class, 'update']);

            // Обновление машины (частичное)
            Route::patch('/update' . RoutePaths::ID, [CarController::class, 'update']);

            // Удаление машины
            Route::delete('/delete' . RoutePaths::ID, [CarController::class, 'destroy']);

            // Генерация тестовых данных для создания машины
            Route::get('/generate-mock', [CarController::class, 'generateMock']);

        });

    });

});
