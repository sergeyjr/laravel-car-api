<?php

namespace App\Repositories\Interfaces;

use App\Models\CarOption;

interface CarOptionRepositoryInterface
{

    public function saveOption(int $carId, array $data): array;

}
