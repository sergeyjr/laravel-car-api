<?php

namespace Modules\API\V1\Mappers;

use Modules\API\V1\DTO\Response\CarListResponse;
use Modules\API\V1\DTO\Response\CarResponse;
use Modules\API\V1\DTO\Response\CarOptionResponse;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\API\V1\Models\CarOption;

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

        $dto->options = [];

        $option = $car['option'] ?? null;

        if ($option) {
            // если приходит массив → оборачиваем в модель
            $model = new CarOption($option);

            $dto->options[] = CarOptionResponse::fromModel($model);
        }

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
