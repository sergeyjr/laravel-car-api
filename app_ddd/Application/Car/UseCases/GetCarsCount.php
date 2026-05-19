<?php

namespace App\Application\Car\UseCases;

use App\Domain\Car\Repositories\CarRepositoryInterface;

class GetCarsCount
{

    public function __construct(
        private CarRepositoryInterface $repository
    )
    {
    }

    public function execute(): int
    {
        return $this->repository->count();
    }

}
