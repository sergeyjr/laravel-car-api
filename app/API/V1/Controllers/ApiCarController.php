<?php

namespace App\API\V1\Controllers;

use App\API\V1\DTO\Request\CarCreateRequest;
use App\API\V1\DTO\Request\CarPatchRequest;
use App\API\V1\DTO\Request\CarUpdateRequest;
use App\API\V1\DTO\Request\PaginationRequest;
use App\API\V1\Services\CarService;
use App\API\V1\Support\CarMapper;
use App\Http\Controllers\Controller;
use Database\Seeders\CarSeeder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiCarController extends Controller
{

    private CarService $service;
    private CarMapper $mapper;

    public const CAR_NOT_FOUND = 'Машина не найдена';
    public const DELETE_SUCCESS = 'Машина с ID :id удалена';
    public const ID_IS_REQUIRED = 'Требуется ID';
    public const VALIDATION_FAILED = 'Проверка не удалась';
    public const ACCESS_DENIDED = 'Доступ запрещён';

    public function __construct(CarService $service, CarMapper $mapper)
    {
        $this->service = $service;
        $this->mapper = $mapper;
    }

    public function list(Request $request): JsonResponse
    {
        $pagination = new PaginationRequest([
            'page' => $request->query('page', 1),
            'perPage' => $request->query('perPage', 6),
            'sort' => $request->query('sort', '-id'),
        ]);

        $cars = $this->service->getCars($pagination);

        return $this->success(
            $this->mapper->toListResponse($cars)
        );
    }

    public function show(int $id): JsonResponse
    {
        $car = $this->service->getCar($id);

        if (!$car) {
            return $this->error(self::CAR_NOT_FOUND, 404);
        }

        return $this->success(
            $this->mapper->toResponse($car)
        );
    }

    public function create(Request $request): JsonResponse
    {
        $dto = CarCreateRequest::fromRequest($request);

        if (!$dto->validate()) {
            return $this->error([
                self::VALIDATION_FAILED,
                $dto->errors
            ], 422);
        }

        $car = $this->service->createCar($dto->toArray());

        return $this->success(
            $this->mapper->toResponse($car),
            201
        );
    }

    public function update(int $id, Request $request): JsonResponse
    {
        if (!$id) {
            return $this->error(self::ID_IS_REQUIRED, 400);
        }

        $dto = CarUpdateRequest::fromRequest($request);

        if (!$dto->validate()) {
            return $this->error([
                self::VALIDATION_FAILED,
                $dto->errors
            ], 422);
        }

        $car = $this->service->updateCar($id, $dto->toArray());

        if (!$car) {
            return $this->error(self::CAR_NOT_FOUND, 404);
        }

        if (($car['user_id'] ?? null) !== auth()->id()) {
            return $this->error(self::ACCESS_DENIDED, 403);
        }

        return $this->success(
            $this->mapper->toResponse($car)
        );
    }

    public function patch(int $id, Request $request): JsonResponse
    {
        if (!$id) {
            return $this->error(self::ID_IS_REQUIRED, 400);
        }

        $dto = CarPatchRequest::fromRequest($request);

        if (!$dto->validate()) {
            return $this->error([
                self::VALIDATION_FAILED,
                $dto->errors
            ], 422);
        }

        $result = $this->service->patchCar($id, $dto->toArray());

        if ($result === 'not_found') {
            return $this->error(self::CAR_NOT_FOUND, 404);
        }

        if ($result === 'forbidden') {
            return $this->error(self::ACCESS_DENIDED, 403);
        }

        return $this->success(
            $this->mapper->toResponse($result)
        );
    }

    public function destroy(int $id): JsonResponse
    {
        if (!$id) {
            return $this->error(self::ID_IS_REQUIRED, 400);
        }

        $result = $this->service->deleteCar($id);

        if ($result === 'not_found') {
            return $this->error(self::CAR_NOT_FOUND, 404);
        }

        if ($result === 'forbidden') {
            return $this->error(self::ACCESS_DENIDED, 403);
        }

        return $this->success([
            'message' => str_replace(':id', $id, self::DELETE_SUCCESS)
        ]);
    }

    public function generateMock(): JsonResponse
    {
        $seeder = new CarSeeder();
        $cars = $seeder->cars;

        $car = $cars[array_rand($cars)];

        [$brand, $model] = explode(' ', $car[0]) + [null, null];

        return $this->success([
            'title' => $car[0],
            'description' => $car[1],
            'price' => $car[2],
            'photo_url' => $seeder->photoUrlDefault,
            'contacts' => $seeder->emailDefault,
            'options' => [
                'brand' => $brand,
                'model' => $model,
                'year' => 2020,
                'body' => $car[3],
                'mileage' => 50000,
            ]
        ]);
    }

}
