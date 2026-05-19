<?php

namespace App\API\V1\Services;

use App\API\V1\DTO\Request\CarOptionRequest;
use App\API\V1\DTO\Request\PaginationRequest;
use App\API\V1\Repositories\Interfaces\CarRepositoryInterface;
use App\Models\Car;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class CarService
{

    private CarRepositoryInterface $repository;

    private const CACHE_TTL = 600;

    public function __construct(CarRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getCar(int $id): ?array
    {
        $cacheKey = "car:$id";

        try {
            return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($id) {
                return $this->repository->findById($id);
            });
        } catch (\Throwable $e) {
            return $this->repository->findById($id);
        }
    }

    public function getCars(PaginationRequest $pagination): LengthAwarePaginator
    {
        $query = $this->repository->getQuery();

        $this->applySort($query, $pagination->sort, $pagination->direction);

        return $query->paginate(
            $pagination->perPage,
            ['*'],
            'page',
            $pagination->page
        );
    }

    public function createCar(array $data): array
    {
        $options = null;

        if (!empty($data['options'])) {
            $dto = CarOptionRequest::fromArray($data['options']);
            $options = $dto->toArray();
        }

        $data['options'] = $options;

        $car = $this->repository->save($data);

        try {
            Cache::forget("car:{$car['id']}");
        } catch (\Throwable $e) {
            // логируем, но не падаем
        }

        return $car;
    }

    public function updateCar(int $id, array $data): array|string|null
    {
        $car = $this->repository->findById($id);

        if (!$car) {
            return 'not_found';
        }

        if (($car['user_id'] ?? null) !== auth()->id()) {
            return 'forbidden';
        }

        $options = null;

        if (!empty($data['options'])) {
            $dto = CarOptionRequest::fromArray($data['options']);
            $options = $dto->toArray();
        }

        $data['options'] = $options;

        $car = $this->repository->update($id, $data);

        try {
            Cache::forget("car:{$car['id']}");
        } catch (\Throwable $e) {
            // логируем, но не падаем
        }

        return $car;
    }

    public function patchCar(int $id, array $data): array|string|null
    {
        $car = $this->repository->findById($id);

        if (!$car) {
            return 'not_found';
        }

        if (($car['user_id'] ?? null) !== auth()->id()) {
            return 'forbidden';
        }

        $options = null;

        if (!empty($data['options'])) {
            $dto = CarOptionRequest::fromArray($data['options']);
            $options = $dto->toArray();
        }

        $data['options'] = $options;

        $data = array_filter($data, fn($v) => $v !== null);

        $car = $this->repository->patch($id, $data);

        try {
            Cache::forget("car:{$car['id']}");
        } catch (\Throwable $e) {
            // логируем, но не падаем
        }

        return $car;
    }

    public function deleteCar(int $id): array|string|null
    {
        $car = $this->repository->findById($id);

        if (!$car) {
            return 'not_found';
        }

        if (($car['user_id'] ?? null) !== auth()->id()) {
            return 'forbidden';
        }

        try {
            Cache::forget("car:{$car['id']}");
        } catch (\Throwable $e) {
            // логируем, но не падаем
        }

        return $this->repository->delete($id);
    }

    private function applySort($query, ?string $sort, string $direction = 'asc'): void
    {
        if (!$sort) {
            return;
        }

        $allowed = ['id', 'title', 'created_at', 'price'];

        if (in_array($sort, $allowed, true)) {
            $query->orderBy($sort, $direction);
        }
    }

    public function getCarsCount(): int
    {
        return Car::count();
    }

}
