<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Car\Repositories\CarRepositoryInterface;
use App\Domain\Shared\Pagination;
use App\Infrastructure\Persistence\Models\CarModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EloquentCarRepository implements CarRepositoryInterface
{

    private EloquentCarOptionRepository $optionRepository;

    public function __construct(EloquentCarOptionRepository $optionRepository)
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
            ]);

            $car->save();

            if (!empty($data['options'])) {
                $this->optionRepository->saveOptions($car->id, $data['options']);
            }

            return $car->load('option')->toArray();
        });
    }

    public function updateFull(int $id, array $data): ?array
    {
        return DB::transaction(function () use ($id, $data) {

            $car = CarModel::with('option')->find($id);

            if (!$car) {
                return null;
            }

            $car->update([
                'title' => $data['title'],
                'description' => $data['description'],
                'price' => $data['price'],
                'photo_url' => $data['photo_url'],
                'contacts' => $data['contacts'],
            ]);

            if (!empty($data['options'])) {
                $car->option()->delete();
                $this->optionRepository->saveOptions($car->id, $data['options']);
            }

            return $car->load('option')->toArray();
        });
    }

    public function updatePartial(int $id, array $data): ?array
    {
        return DB::transaction(function () use ($id, $data) {

            $car = CarModel::with('option')->find($id);

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

                $options = array_filter([
                    'brand' => $data['options']['brand'] ?? null,
                    'model' => $data['options']['model'] ?? null,
                    'year' => $data['options']['year'] ?? null,
                    'body' => $data['options']['body'] ?? null,
                    'mileage' => $data['options']['mileage'] ?? null,
                ], fn($v) => $v !== null);

                if ($car->option) {
                    $car->option->update($options);
                }
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

    public function paginate(Pagination $pagination): LengthAwarePaginator
    {
        $query = CarModel::query()->with('option');

        $this->applySort($query, $pagination->sort);

        return $query->paginate(
            perPage: $pagination->perPage,
            page: $pagination->page
        );
    }

    public function applySort(Builder $query, ?string $sort): void
    {
        $allowed = ['id', 'title', 'created_at', 'price'];

        $field = 'id';
        $direction = 'desc';

        if ($sort) {
            if (str_starts_with($sort, '-')) {
                $direction = 'desc';
                $field = ltrim($sort, '-');
            } else {
                $direction = 'asc';
                $field = $sort;
            }

            if (!in_array($field, $allowed, true)) {
                $field = 'id';
            }
        }

        $query->orderBy($field, $direction);
    }

    public function findById(int $id): ?array
    {
        $car = CarModel::with('option')->find($id);
        return $car?->toArray();
    }

    public function count(): int
    {
        return CarModel::count();
    }

}
