<?php

namespace App\Infrastructure\Persistence\Mappers;

use App\Application\Car\DTO\CarListOutput;
use App\Application\Car\DTO\CarOptionOutput;
use App\Application\Car\DTO\CarOutput;
use App\Application\Shared\PaginationResult;

class CarMapper
{

//    public function toDomain(CarModel $model): Car
//    {
//        return new Car(
//            new CarId($model->id),
//            new CarName($model->name)
//        );
//    }
//
//    public function toModel(Car $car): CarModel
//    {
//        return new CarModel([
//            'id' => $car->id()->value(),
//            'name' => $car->name()->value(),
//        ]);
//    }

    public function toResponse(array $car): CarOutput
    {
        $dto = new CarOutput();

        $dto->id = $car['id'] ?? null;
        $dto->title = $car['title'] ?? null;
        $dto->description = $car['description'] ?? null;
        $dto->price = $car['price'] ?? null;
        $dto->photo_url = $car['photo_url'] ?? null;
        $dto->contacts = $car['contacts'] ?? null;

        $dto->options = null;

        if (!empty($car['option'])) {
            $dto->options = CarOptionOutput::fromArray($car['option']);
        }

        return $dto;
    }

    public function toListResponse(PaginationResult $paginator): CarListOutput
    {
        $items = [];

        foreach ($paginator->items as $car) {
            $items[] = $this->toResponse(
                is_array($car) ? $car : $car->toArray()
            );
        }

        return new CarListOutput(
            items: $items,
            page: $paginator->page,
            total: $paginator->total,
            perPage: $paginator->perPage
        );
    }

}
