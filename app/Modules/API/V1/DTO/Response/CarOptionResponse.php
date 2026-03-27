<?php

namespace Modules\API\V1\DTO\Response;

use Modules\API\V1\Models\CarOption;

class CarOptionResponse
{

    public string $brand;
    public string $model;
    public int $year;
    public string $body;
    public int $mileage;

    public static function fromModel(CarOption $option): self
    {
        $dto = new self();

        $dto->brand = $option->brand;
        $dto->model = $option->model;
        $dto->year = $option->year;
        $dto->body = $option->body;
        $dto->mileage = $option->mileage;

        return $dto;
    }

}
