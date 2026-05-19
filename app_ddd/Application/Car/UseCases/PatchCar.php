<?php

namespace App\Application\Car\UseCases;

use App\Domain\Car\Repositories\CarRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class PatchCar
{

    public function __construct(
        private CarRepositoryInterface $repository
    )
    {
    }

    public function execute(int $id, object $data): ?array
    {
        $payload = array_filter([
            'title' => $data->title ?? null,
            'description' => $data->description ?? null,
            'price' => $data->price ?? null,
            'photo_url' => $data->photo_url ?? null,
            'contacts' => $data->contacts ?? null,
        ], fn($v) => $v !== null);

        if (isset($data->options)) {
            $payload['options'] = array_filter([
                'brand' => $data->options['brand'] ?? null,
                'model' => $data->options['model'] ?? null,
                'year' => $data->options['year'] ?? null,
                'body' => $data->options['body'] ?? null,
                'mileage' => $data->options['mileage'] ?? null,
            ], fn($v) => $v !== null);
        }

        $car = $this->repository->updatePartial($id, $payload);

        try {
            Cache::forget("car:{$car['id']}");
        } catch (\Throwable) {
        }

        return $car;
    }

}
