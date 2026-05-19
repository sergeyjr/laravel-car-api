<?php

namespace App\API\V1\Repositories\Interfaces;

interface CarOptionRepositoryInterface
{

    public function saveOptions(int $carId, array $data): array;

}
