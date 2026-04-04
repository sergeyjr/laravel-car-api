<?php

namespace Modules\API\V1\Http\Controllers;

use Illuminate\Http\Request;
use Modules\API\V1\Services\CarService;
use Modules\API\V1\Mappers\CarMapper;
use Modules\API\V1\DTO\Request\CarCreateRequest;
use Modules\API\V1\DTO\Request\PaginationRequest;
use Database\Seeders\CarSeeder;

class CarController extends BaseApiController
{

    private CarService $service;
    private CarMapper $mapper;

    public const CAR_NOT_FOUND = 'Машина не найдена';

    public function __construct(CarService $service, CarMapper $mapper)
    {
        $this->service = $service;
        $this->mapper = $mapper;
    }

    /**
     * Создание машины
     */
    public function create(Request $request)
    {
        $dto = CarCreateRequest::fromRequest($request);

        if (!$dto->validate()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $dto->errors
            ], 422);
        }

        $car = $this->service->createCar($dto);

        return $this->success(
            $this->mapper->toResponse($car),
            201
        );
    }

    /**
     * Получение машины по ID
     */
    public function show(int $id)
    {
        $car = $this->service->getCar($id);

        if (!$car) {
            return $this->error(self::CAR_NOT_FOUND, 404);
        }

        return $this->success(
            $this->mapper->toResponse($car)
        );
    }

    /**
     * Получение списка машин
     */
    public function index(Request $request)
    {
        $dto = PaginationRequest::fromRequest($request);

        $cars = $this->service->getCars($dto);

        return $this->success(
            $this->mapper->toListResponse($cars)
        );
    }

    /**
     * Обновление машины
     */
    public function update(int $id, Request $request)
    {
        $isFull = $request->isMethod('put');

        $car = $this->service->updateCar($id, $request->all(), $isFull);

        if (!$car) {
            return $this->error(self::CAR_NOT_FOUND, 404);
        }

        return $this->success(
            $this->mapper->toResponse($car)
        );
    }

    /**
     * Удаление машины
     */
    public function destroy(int $id)
    {
        $deleted = $this->service->deleteCar($id);

        if (!$deleted) {
            return $this->error(self::CAR_NOT_FOUND, 404);
        }

        return $this->success(null, 204);
    }

    /**
     * Генерация тестовых данных для создания машины
     */
    public function generateMock()
    {

        $seeder = new CarSeeder();

        $cars = $seeder->cars;

        $car = $cars[array_rand($cars)];

        [$brand, $model] = explode(' ', $car[0]) + [null, null];

        $optionsArray = [
            'brand' => $brand,
            'model' => $model,
            'year' => 2020,
            'body' => $car[3],
            'mileage' => 50000,
        ];

        return $this->success([
            'title' => $car[0],
            'description' => $car[1],
            'price' => $car[2],
            'photo_url' => $seeder->photoUrlDefault,
            'contacts' => $seeder->emailDefault,
            'options' => $optionsArray
        ]);

    }

}
