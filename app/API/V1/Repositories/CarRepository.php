<?php

namespace App\API\V1\Repositories;

use App\API\V1\Models\CarModel;
use App\API\V1\Repositories\Interfaces\CarRepositoryInterface;
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

            $car = new CarModel();

            $car->fill([
                'title' => $data['title'],
                'description' => $data['description'],
                'price' => $data['price'],
                'photo_url' => $data['photo_url'],
                'contacts' => $data['contacts'],
                'user_id' => $data['user_id'] ?? null,
            ]);

            $car->save();

            if (!empty($data['options'])) {
                $this->optionRepository->saveOptions($car->id, $data['options']);
            }

            return $car->load('option')->toArray(); // hasOne
        });
    }

    public function update(int $id, array $data): ?array
    {
        return DB::transaction(function () use ($id, $data) {

            $car = CarModel::with('option')->find($id); // hasOne

            if (!$car) {
                return null;
            }

            $car->update([
                'title' => $data['title'],
                'description' => $data['description'],
                'price' => $data['price'],
                'photo_url' => $data['photo_url'],
                'contacts' => $data['contacts'],
                'user_id' => $data['user_id'] ?? null,

            ]);

            if (!empty($data['options'])) {
                $car->option()->delete();
                $this->optionRepository->saveOptions($car->id, $data['options']);
            }

            return $car->load('option')->toArray();
        });
    }

    public function patch(int $id, array $data): ?array
    {
        return DB::transaction(function () use ($id, $data) {

            $car = CarModel::with('option')->find($id); // hasOne

            if (!$car) {
                return null;
            }

            $car->update(array_filter([
                'title' => $data['title'] ?? null,
                'description' => $data['description'] ?? null,
                'price' => $data['price'] ?? null,
                'photo_url' => $data['photo_url'] ?? null,
                'contacts' => $data['contacts'] ?? null,
            ], fn($v) => $v !== null));

            if (!empty($data['options'])) {
                $car->option()->updateOrCreate([],
                    array_filter([
                        'brand' => $data['options']['brand'] ?? null,
                        'model' => $data['options']['model'] ?? null,
                        'year' => $data['options']['year'] ?? null,
                        'body' => $data['options']['body'] ?? null,
                        'mileage' => $data['options']['mileage'] ?? null,
                    ], fn($v) => $v !== null)
                );
            }

            return $car->load('option')->toArray();
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {

            $car = CarModel::with('option')->find($id);

            if (!$car) {
                return false;
            }

            $car->option()->delete();
            $car->delete();

            return true;
        });
    }

    public function findById(int $id): ?array
    {
        $car = CarModel::with('option')->find($id);
        return $car?->toArray();
    }

    public function getQuery(): Builder
    {
        return CarModel::with('option');
    }

}
