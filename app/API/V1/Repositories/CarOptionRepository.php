<?php

namespace App\API\V1\Repositories;

use App\API\V1\Exceptions\RepositoryException;
use App\API\V1\Models\CarOptionModel;
use App\API\V1\Repositories\Interfaces\CarOptionRepositoryInterface;

class CarOptionRepository implements CarOptionRepositoryInterface
{

    /**
     * @throws RepositoryException
     */
    public function saveOptions(int $carId, array $data): array
    {

        $options = new CarOptionModel();

        $options->car_id = $carId;

        $options->brand = $data['brand'];
        $options->model = $data['model'];
        $options->year = $data['year'];
        $options->body = $data['body'];
        $options->mileage = $data['mileage'];

        if (!$options->save()) {
            throw new RepositoryException('Не удалось сохранить опции автомобиля');
        }

        return $options->toArray();

    }

}
