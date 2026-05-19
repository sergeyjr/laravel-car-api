<?php

namespace App\Domain\Car\Repositories;

use App\Domain\Shared\Pagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

interface CarRepositoryInterface
{

    public function save(array $data): array;

    public function updateFull(int $id, array $data): ?array;

    public function updatePartial(int $id, array $data): ?array;

    public function delete(int $id): bool;

    public function findById(int $id): ?array;

    public function paginate(Pagination $pagination): LengthAwarePaginator;

    public function applySort(Builder $query, ?string $sort): void;

    public function count(): int;

}
