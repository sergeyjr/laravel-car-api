<?php

namespace App\Http\Controllers;

use Modules\API\V1\DTO\Request\PaginationRequest;
use Modules\API\V1\Models\Car;
use Modules\API\V1\Services\CarService;
use Illuminate\Http\Request;

class CarsController extends Controller
{

    public function __construct(
        private CarService $service
    ) {}

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
    public function show($id)
    {
        $car = Car::with('option')->findOrFail($id);

        return view('cars.show', [
            'car' => $car
        ]);
    }

    public function create()
    {
        return view('cars.create');
    }

}
