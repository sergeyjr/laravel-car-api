<?php

namespace App\Http\Controllers;

use App\API\V1\DTO\Request\PaginationRequest;
use App\API\V1\Services\CarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarController extends Controller
{

    public function __construct(
        private readonly CarService $service
    )
    {
    }

    /**
     * Возвращает список машин
     */
    public function list(Request $request): JsonResponse
    {
        $pagination = new PaginationRequest([
            'page' => $request->query('page', 1),
            'perPage' => 6,
            'sort' => $request->query('sort', '-id'),
        ]);

        $cars = $this->service->getCars($pagination);

        return response()->json($cars);
    }

    /**
     * Получение одной машины
     */
    public function show($id): JsonResponse
    {
        $car = $this->service->getCar((int)$id);

        if (!$car) {
            return response()->json([
                'message' => 'Машина не найдена.'
            ], 404);
        }

        return $this->success($car);
    }

    /**
     * Новинки
     */
    public function latest(): JsonResponse
    {
        $pagination = new PaginationRequest([
            'page' => 1,
            'perPage' => 6,
            'sort' => '-id',
        ]);

        $cars = $this->service->getCars($pagination);

        return response()->json($cars);
    }

}
