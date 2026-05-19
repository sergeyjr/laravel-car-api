<?php

namespace App\API\V1\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface CarRepositoryInterface
{

    public function save(array $data): array;

    public function update(int $id, array $data): ?array;

    public function patch(int $id, array $data): ?array;

    public function delete(int $id): bool;

    public function findById(int $id): ?array;

    public function getQuery(): Builder;

}
