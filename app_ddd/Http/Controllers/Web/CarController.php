<?php

namespace App\Http\Controllers\Web;

use App\Application\Car\UseCases\GetCar;
use App\Application\Car\UseCases\GetCars;
use App\Domain\Shared\Pagination;
use Illuminate\Http\Request;

class CarController extends Controller
{

    public function __construct(
        private GetCar  $getCar,
        private GetCars $getCars,
    )
    {
    }

    public function list(Request $request)
    {
        $pagination = new Pagination(
            page: (int)$request->query('page', 1),
            perPage: 6,
            sort: $request->query('sort', '-id'),
        );

        $cars = $this->getCars->execute($pagination);

        return response()->json($cars);
    }

    public function show(int $id)
    {
        $car = $this->getCar->execute($id);

        if (!$car) {
            return response()->json([
                'message' => 'Машина не найдена.'
            ], 404);
        }

        return $this->success($car);
    }

    public function latest()
    {
        $pagination = new Pagination(
            page: 1,
            perPage: 6,
            sort: '-id',
        );

        $cars = $this->getCars->execute($pagination);

        return response()->json($cars);
    }

}
