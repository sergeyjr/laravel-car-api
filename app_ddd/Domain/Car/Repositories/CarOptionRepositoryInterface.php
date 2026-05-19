<?php

namespace App\Domain\Car\Repositories;

interface CarOptionRepositoryInterface
{

    public function saveOptions(int $carId, array $data): array;

}
