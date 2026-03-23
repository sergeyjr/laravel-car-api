<?php

namespace App\Services;

use App\DTO\Request\CreateCarDTO;
use App\DTO\Request\PaginationDTO;
use App\Models\Car;
use App\Repositories\Interfaces\CarRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class CarService
{

    private CarRepositoryInterface $repository;

    // private const CACHE_VERSION_KEY = 'cars_cache_version';
    private const CACHE_TTL = 600;

    public function __construct(CarRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createCar(CreateCarDTO $request): Car
    {

        $car = $this->repository->save([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'photo_url' => $request->photo_url,
            'contacts' => $request->contacts,
            'options' => $request->options,
        ]);

        // инвалидируем список
        // Cache::increment(self::CACHE_VERSION_KEY);

        // инвалидируем конкретную машину
        Cache::forget("car:{$car->id}");

        return $car;

    }

    public function getCar(int $id): ?Car
    {
        $cacheKey = "car:$id";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($id) {
            return $this->repository->findById($id);
        });
    }

    public function getCars(PaginationDTO $pagination): LengthAwarePaginator
    {
        $query = $this->repository->getQuery();

        $this->applySort($query, $pagination->sort);

        return $query->paginate(
            $pagination->pageSize,
            ['*'],
            'page',
            $pagination->page
        );

    }

    private function applySort($query, ?string $sort): void
    {
        if (!$sort) return;

        $direction = str_starts_with($sort, '-') ? 'desc' : 'asc';
        $field = ltrim($sort, '-');

        $query->orderBy($field, $direction);
    }

}
