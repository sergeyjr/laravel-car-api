<?php

namespace Modules\API\V1\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Modules\API\V1\DTO\Request\CarCreateRequest;
use Modules\API\V1\DTO\Request\CarOptionRequest;
use Modules\API\V1\DTO\Request\PaginationRequest;
use Modules\API\V1\Exceptions\ServiceException;
use Modules\API\V1\Repositories\Interfaces\CarRepositoryInterface;

class CarService
{

    private CarRepositoryInterface $repository;

    private const CACHE_TTL = 600;

    public function __construct(CarRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createCar(CarCreateRequest $request): array
    {
        $options = [];

        foreach ($request->options ?? [] as $item) {
            $optionDto = CarOptionRequest::fromArray($item);

            if (!$optionDto->validate()) {
                $message = json_encode($optionDto->errors);
                throw new ServiceException($message);
            }

            $options[] = $optionDto->toArray();
        }

        $car = $this->repository->save([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'photo_url' => $request->photo_url,
            'contacts' => $request->contacts,
            'options' => $options,
        ]);

        Cache::forget("car:{$car['id']}");

        return $car;
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

        $sort = $pagination->sort ?? '-id';

        $this->applySort($query, $sort);

        return $query->paginate(
            $pagination->pageSize,
            ['*'],
            'page',
            $pagination->page
        );
    }

    public function updateCar(int $id, array $data, bool $isFull = false): ?array
    {
        return $this->repository->update($id, $data, $isFull);
    }

    public function deleteCar(int $id): bool
    {
        return $this->repository->delete($id);
    }

    private function applySort($query, ?string $sort): void
    {
        if (!$sort) {
            return;
        }

        $direction = str_starts_with($sort, '-') ? 'desc' : 'asc';
        $field = ltrim($sort, '-');

        $query->orderBy($field, $direction);
    }

}
