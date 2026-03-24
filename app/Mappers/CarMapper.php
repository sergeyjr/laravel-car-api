<?php

namespace App\Mappers;

use App\DTO\Response\CarListResponse;
use App\DTO\Response\CarResponse;
use App\Models\Car;
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

        $option = $car['option'] ?? null;

        $dto->options = $option ? [[
            'brand' => $option['brand'] ?? null,
            'model' => $option['model'] ?? null,
            'year' => $option['year'] ?? null,
            'body' => $option['body'] ?? null,
            'mileage' => $option['mileage'] ?? null,
        ]] : [];

        return $dto;
    }

    public function toListResponse(LengthAwarePaginator $paginator): CarListResponse
    {
        $items = [];

        foreach ($paginator->items() as $car) {
            $items[] = $this->toResponse(
                $car->toArray()
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
