<?php

namespace App\Repositories\Interfaces;

use App\Models\Car;
use Illuminate\Database\Eloquent\Builder;

interface CarRepositoryInterface
{
    public function save(array $data): Car;

    public function findById(int $id): ?Car;

    public function getQuery(): Builder;
}
