<?php

namespace App\API\V1\Support;

use App\API\V1\DTO\Response\CarListResponse;
use App\API\V1\DTO\Response\CarOptionResponse;
use App\API\V1\DTO\Response\CarResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CarMapper
{

    public function toResponse(array $car): CarResponse
    {
        $dto = new CarResponse();

        $dto->id = $car['id'] ?? null;
        $dto->title = $car['title'] ?? null;
        $dto->description = $car['description'] ?? null;
        $dto->price = $car['price'] ?? null;
        $dto->photo_url = $car['photo_url'] ?? null;
        $dto->contacts = $car['contacts'] ?? null;
        $dto->user_id = $car['user_id'] ?? null;

        $dto->options = null;

        if (!empty($car['option'])) { // hasOne
            $dto->options = CarOptionResponse::fromArray($car['option']);
        }

        return $dto;
    }

    public function toListResponse(LengthAwarePaginator $paginator): CarListResponse
    {
        $items = [];

        foreach ($paginator->items() as $car) {
            $items[] = $this->toResponse(
                is_array($car) ? $car : $car->toArray()
            );
        }

        return new CarListResponse(
            $items,
            $paginator->currentPage(),
            $paginator->total(),
            $paginator->perPage()
        );
    }

}
