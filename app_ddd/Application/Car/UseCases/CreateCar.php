<?php

namespace App\Application\Car\UseCases;

use App\Application\Car\DTO\CarCreateInput;
use App\Domain\Car\Repositories\CarRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class CreateCar
{

    public function __construct(
        private CarRepositoryInterface $repository
    )
    {
    }

    public function execute(CarCreateInput $data): array
    {
        $payload = [
            'title' => $data->title,
            'description' => $data->description,
            'price' => $data->price,
            'photo_url' => $data->photo_url,
            'contacts' => $data->contacts,
            //'options' => null,
        ];

        if (!empty($data->options)) {
            $payload['options'] = array_filter([
                'brand' => $data->options['brand'] ?? null,
                'model' => $data->options['model'] ?? null,
                'year' => $data->options['year'] ?? null,
                'body' => $data->options['body'] ?? null,
                'mileage' => $data->options['mileage'] ?? null,
            ], fn($v) => $v !== null);
        }

        $car = $this->repository->save($payload);

        try {
            Cache::forget("car:{$car['id']}");
        } catch (\Throwable) {
        }

        return $car;
    }

}
