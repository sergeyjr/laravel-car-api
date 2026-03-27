<?php

namespace Modules\API\V1\Repositories\Interfaces;

interface CarOptionRepositoryInterface
{

    public function saveOption(int $carId, array $data): array;

}
