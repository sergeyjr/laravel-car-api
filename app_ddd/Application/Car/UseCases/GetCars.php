<?php

namespace App\Application\Car\UseCases;

use App\Domain\Shared\Pagination;
use App\Application\Shared\PaginationResult;
use App\Domain\Car\Repositories\CarRepositoryInterface;

class GetCars
{

    public function __construct(
        private CarRepositoryInterface $repository
    )
    {
    }

    public function execute(Pagination $pagination): PaginationResult
    {
        $paginator = $this->repository->paginate($pagination);

        return new PaginationResult(
            items: $paginator->items(),
            page: $paginator->currentPage(),
            total: $paginator->total(),
            perPage: $paginator->perPage(),
            lastPage: $paginator->lastPage(),
        );
    }

}
