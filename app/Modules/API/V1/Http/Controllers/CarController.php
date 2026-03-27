<?php

namespace Modules\API\V1\Http\Controllers;

use Illuminate\Http\Request;
use Modules\API\V1\Services\CarService;
use Modules\API\V1\Mappers\CarMapper;
use Modules\API\V1\DTO\Request\CarCreateRequest;
use Modules\API\V1\DTO\Request\PaginationRequest;

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
        if (is_array($request->all()) && array_is_list($request->all())) {
            return $this->error([
                'message' => 'Invalid request format. Expected single object, array given.'
            ], 422);
        }

        $dto = CarCreateRequest::fromRequest($request);

        if (!$dto->validate()) {
            return $this->error($dto->errors, 422);
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

}
