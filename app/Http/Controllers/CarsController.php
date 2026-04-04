<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\API\V1\DTO\Request\PaginationRequest;
use Modules\API\V1\Models\Car;
use Modules\API\V1\Services\CarService;

class CarsController extends Controller
{

    public function __construct(
        private CarService $service
    ) {}

    /**
     * Получение списка машин
     */
    public function index(Request $request)
    {
        $pagination = new PaginationRequest([
            'page' => $request->query('page', 1),
            'pageSize' => 6,
            'sort' => $request->query('sort', '-id'),
        ]);

        $cars = $this->service->getCars($pagination);

        return view('cars.index', compact('cars'));
    }

    /**
     * Получение машины по ID
     */
    public function show($id)
    {
        $car = Car::with('option')->findOrFail($id);

        return view('cars.show', [
            'car' => $car
        ]);
    }

    /**
     * Создание машины
     */
    public function create()
    {
        return view('cars.create');
    }

}
