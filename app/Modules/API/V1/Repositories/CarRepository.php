<?php

namespace Modules\API\V1\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\API\V1\Models\Car;
use Modules\API\V1\Repositories\Interfaces\CarRepositoryInterface;

class CarRepository implements CarRepositoryInterface
{

    private CarOptionRepository $optionRepository;

    public function __construct(CarOptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }

    /**
     * @param array $data
     * @return array
     * @throws \Throwable
     */
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

    /**
     * @param int $id
     * @param array $data
     * @param bool $isFull
     * @return array|null
     * @throws \Throwable
     */
    public function update(int $id, array $data, bool $isFull = false): ?array
    {
        return DB::transaction(function () use ($id, $data, $isFull) {

            $car = Car::with('options')->find($id);

            if (!$car) {
                return null;
            }

            if ($isFull) {

                // FULL UPDATE (PUT)
                $car->update([
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'photo_url' => $data['photo_url'],
                    'contacts' => $data['contacts'],
                ]);

            } else {

                // PARTIAL UPDATE (PATCH)
                $car->update(array_filter([
                    'title' => $data['title'] ?? null,
                    'description' => $data['description'] ?? null,
                    'price' => $data['price'] ?? null,
                    'photo_url' => $data['photo_url'] ?? null,
                    'contacts' => $data['contacts'] ?? null,
                ], fn($v) => !is_null($v)));
            }

            if (array_key_exists('options', $data)) {

                $car->options()->delete();

                if (!empty($data['options'])) {
                    $car->options()->createMany($data['options']);
                }
            }

            return $car->load('options')->toArray();
        });
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Throwable
     */
    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {

            $car = Car::with('options')->find($id);

            if (!$car) {
                return false;
            }

            $car->options()->delete();
            $car->delete();

            return true;
        });
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function findById(int $id): ?array
    {
        $car = Car::with('option')->find($id);
        return $car ? $car->toArray() : null;
    }

    /**
     * @return Builder
     */
    public function getQuery(): Builder
    {
        return Car::with('options');
    }

}
