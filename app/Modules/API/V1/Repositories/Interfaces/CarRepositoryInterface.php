<?php

namespace Modules\API\V1\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface CarRepositoryInterface
{

    public function save(array $data): array;

    public function findById(int $id): ?array;

    public function getQuery(): Builder;

}
