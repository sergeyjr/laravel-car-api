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

    public function __construct(CarService $service, CarMapper $mapper)
    {
        $this->service = $service;
        $this->mapper = $mapper;
    }

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

    public function view(int $id)
    {
        $car = $this->service->getCar($id);

        if (!$car) {
            return $this->error('Car not found', 404);
        }

        return $this->success(
            $this->mapper->toResponse($car)
        );
    }

    public function list(Request $request)
    {
        $dto = PaginationRequest::fromRequest($request);

        $cars = $this->service->getCars($dto);

        return $this->success(
            $this->mapper->toListResponse($cars)
        );
    }

    public function generateMock()
    {

        $seeder = new CarSeeder();

        $cars = $seeder->cars;

        $car = $cars[array_rand($cars)];

        return $this->success([
            'title' => $car[0],
            'description' => $car[1],
            'price' => $car[2],
            'photo_url' => $seeder->photoUrlDefault,
            'contacts' => 'admin@example.com',
        ]);
    }

}
