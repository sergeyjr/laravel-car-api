<?php

namespace App\Mappers;

use App\DTO\Response\CarListResponse;
use App\DTO\Response\CarResponse;
use App\Models\Car;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CarMapper
{
    public function toResponse(Car $car): CarResponse
    {
        $dto = new CarResponse();

        $dto->id = $car->id;
        $dto->title = $car->title;
        $dto->description = $car->description;
        $dto->price = $car->price;
        $dto->photo_url = $car->photo_url;
        $dto->contacts = $car->contacts;

        $option = $car->option;

        $dto->options = $option ? [[
            'brand' => $option->brand,
            'model' => $option->model,
            'year' => $option->year,
            'body' => $option->body,
            'mileage' => $option->mileage,
        ]] : null;

        return $dto;
    }

    public function toListResponse(LengthAwarePaginator $paginator): CarListResponse
    {
        $items = [];

        foreach ($paginator->items() as $car) {
            $items[] = $this->toResponse($car);
        }

        return new CarListResponse(
            $items,
            $paginator->currentPage(),
            $paginator->total(),
            $paginator->perPage()
        );
    }
}
