<?php

namespace App\Repositories;

use App\Models\Car;
use App\Repositories\Interfaces\CarRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CarRepository implements CarRepositoryInterface
{
    private CarOptionRepository $optionRepository;

    public function __construct(CarOptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    public function save(array $data): Car
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
                $options = $data['options'];
                if (is_array($options) && isset($options['brand'])) {
                    $options = [$options];
                }
                if (is_array($options)) {
                    foreach ($options as $option) {
                        if (!is_array($option)) {
                            continue;
                        }
                        $this->optionRepository->saveOption($car->id, $option);
                    }
                }
            }

            return $car->load('option');
        });
    }

    public function findById(int $id): ?Car
    {
        return Car::with('option')->find($id);
    }

    public function getQuery(): Builder
    {
        return Car::with('option');//->query();
    }
}
