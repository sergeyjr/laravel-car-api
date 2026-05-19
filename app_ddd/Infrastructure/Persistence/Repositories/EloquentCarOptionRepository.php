<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Car\Repositories\CarOptionRepositoryInterface;
use App\Infrastructure\Persistence\Models\CarOptionModel;

class EloquentCarOptionRepository implements CarOptionRepositoryInterface
{

    public function saveOptions(int $carId, array $data): array
    {
        $options = new CarOptionModel();

        $options->car_id = $carId;

        $options->fill(array_filter([
            'brand' => $data['brand'] ?? null,
            'model' => $data['model'] ?? null,
            'year' => $data['year'] ?? null,
            'body' => $data['body'] ?? null,
            'mileage' => $data['mileage'] ?? null,
        ], fn($v) => $v !== null));

        if (!$options->save()) {
            throw new \Exception('Не удалось сохранить опции автомобиля');
        }

        return $options->toArray();
    }

}
