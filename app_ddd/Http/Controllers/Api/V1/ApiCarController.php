<?php

namespace App\Http\Controllers\Api\V1;

use App\Application\Car\UseCases\CreateCar;
use App\Application\Car\UseCases\DeleteCar;
use App\Application\Car\UseCases\GetCar;
use App\Application\Car\UseCases\GetCars;
use App\Application\Car\UseCases\PatchCar;
use App\Application\Car\UseCases\UpdateCar;
use App\Domain\Shared\Pagination;
use App\Http\Controllers\Web\Controller;
use App\Http\Requests\Car\CarCreateRequest;
use App\Http\Requests\Car\CarPatchRequest;
use App\Http\Requests\Car\CarUpdateRequest;
use App\Http\Requests\PaginationRequest;
use App\Infrastructure\Persistence\Mappers\CarMapper;
use Database\Seeders\CarSeeder;
use Illuminate\Http\Request;

class ApiCarController extends Controller
{

    public function __construct(
        private GetCar    $getCar,
        private GetCars   $getCars,
        private CreateCar $createCar,
        private UpdateCar $updateCar,
        private PatchCar $patchCar,
        private DeleteCar $deleteCar,
        private CarMapper $mapper,
    )
    {
    }

    public function list(Request $request)
    {
        $dto = new PaginationRequest([
            'page' => $request->query('page', 1),
            'perPage' => $request->query('perPage', 6),
            'sort' => $request->query('sort', '-id'),
        ]);

        $pagination = new Pagination(
            page: $dto->page,
            perPage: $dto->perPage,
            sort: $dto->sort,
        );

        $cars = $this->getCars->execute($pagination);

        return $this->success(
            $this->mapper->toListResponse($cars)
        );
    }

    public function show(int $id)
    {
        $car = $this->getCar->execute($id);

        if (!$car) {
            return $this->error('Машина не найдена', 404);
        }

        return $this->success(
            $this->mapper->toResponse($car)
        );
    }

    public function create(CarCreateRequest $request)
    {
        $dto = $request->toDTO();

        $car = $this->createCar->execute($dto);

        return $this->success(
            $this->mapper->toResponse($car),
            201
        );
    }

    public function update(int $id, CarUpdateRequest $request)
    {
        $dto = $request->toDTO();

        $car = $this->updateCar->execute($id, $dto);

        if (!$car) {
            return $this->error('Машина не найдена', 404);
        }

        return $this->success(
            $this->mapper->toResponse($car)
        );
    }

    public function patch(int $id, CarPatchRequest $request)
    {
        $dto = $request->toDTO();

        $car = $this->patchCar->execute($id, $dto);

        if (!$car) {
            return $this->error('Машина не найдена', 404);
        }

        return $this->success(
            $this->mapper->toResponse($car)
        );
    }

    public function destroy(int $id)
    {
        $deleted = $this->deleteCar->execute($id);

        if (!$deleted) {
            return $this->error('Машина не найдена', 404);
        }

        return $this->success([
            'message' => "Машина с ID {$id} удалена"
        ]);
    }

    public function generateMock()
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
