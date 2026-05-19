<?php

namespace App\Application\Car\UseCases;

use App\Domain\Car\Repositories\CarRepositoryInterface;

class DeleteCar
{

    public function __construct(
        private CarRepositoryInterface $repository
    )
    {
    }

    public function execute(int $id): bool
    {
        return $this->repository->delete($id);
    }

}
