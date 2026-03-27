<?php

namespace Modules\API\V1\Repositories;

use Modules\API\V1\Models\Car;
use Modules\API\V1\Repositories\Interfaces\CarRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CarRepository implements CarRepositoryInterface
{

    private CarOptionRepository $optionRepository;

    public function __construct(CarOptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    public function save(array $data): array
    {
        return DB::transaction(function () use ($data) {

            $car = new Car();

            $car->title = $data['title'];
            $car->description = $data['description'];
            $car->price = $data['price'];
            $car->photo_url = $data['photo_url'];
            $car->contacts = $data['contacts'];

            $car->save();

            if (!empty($data['options'])) {
                foreach ($data['options'] as $option) {
                    $this->optionRepository->saveOption($car->id, $option);
                }
            }

            return $car->load('option')->toArray();
        });
    }

    public function findById(int $id): ?array
    {
        $car = Car::with('option')->find($id);
        return $car ? $car->toArray() : null;
    }

    public function getQuery(): Builder
    {
        return Car::with('option');
    }

}
