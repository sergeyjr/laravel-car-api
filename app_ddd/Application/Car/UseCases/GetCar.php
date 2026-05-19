<?php

namespace App\Application\Car\UseCases;

use App\Domain\Car\Repositories\CarRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class GetCar
{

    private const CACHE_TTL = 600;

    public function __construct(
        private CarRepositoryInterface $repository
    )
    {
    }

    public function execute(int $id): ?array
    {
        $cacheKey = "car:$id";

        try {
            return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($id) {
                return $this->repository->findById($id);
            });
        } catch (\Throwable) {
            return $this->repository->findById($id);
        }
    }

}
