<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\API\V1\Services\CarService;
use Modules\API\V1\Mappers\CarMapper;
use Modules\API\V1\DTO\Request\PaginationRequest;

class CarsController extends Controller
{
    public function index(
        Request $request,
        CarService $service,
        CarMapper $mapper
    ) {
        $pagination = PaginationRequest::fromRequest($request);

        $paginator = $service->getCars($pagination);

        $list = $mapper->toListResponse($paginator);

        return view('cars', [
            'cars' => $list->items,
            'pagination' => [
                'current_page' => $list->page,
                'total' => $list->total,
                'per_page' => $list->perPage,
            ],
            'selectedCar' => null
        ]);
    }

    public function show(
        int $id,
        CarService $service,
        CarMapper $mapper
    ) {
        $car = $service->getCar($id);

        if (!$car) {
            return view('cars', [
                'cars' => [],
                'selectedCar' => null
            ]);
        }

        $item = $mapper->toResponse($car);

        return view('cars', [
            'cars' => [],
            'selectedCar' => $item
        ]);
    }
}
