<?php

namespace Modules\API\V1\Repositories;

use Modules\API\V1\Exceptions\RepositoryException;
use Modules\API\V1\Models\CarOption;
use Modules\API\V1\Repositories\Interfaces\CarOptionRepositoryInterface;

class CarOptionRepository implements CarOptionRepositoryInterface
{

    public function saveOption(int $carId, array $data): array
    {
        $option = new CarOption();

        $option->car_id = $carId;
        $option->brand = $data['brand'];
        $option->model = $data['model'];
        $option->year = $data['year'];
        $option->body = $data['body'];
        $option->mileage = $data['mileage'];

        if (!$option->save()) {
            throw new RepositoryException('Failed to save car option');
        }

        return $option->toArray();
    }

}
