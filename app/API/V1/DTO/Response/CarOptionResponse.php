<?php

namespace App\API\V1\DTO\Response;

class CarOptionResponse
{

    public string $brand;
    public string $model;
    public int $year;
    public string $body;
    public int $mileage;

    public static function fromArray(array $data): self
    {
        $dto = new self();

        if (isset($data['brand'])) {
            $dto->brand = $data['brand'];
        }
        if (isset($data['model'])) {
            $dto->model = $data['model'];
        }
        if (isset($data['year'])) {
            $dto->year = (int)$data['year'];
        }
        if (isset($data['body'])) {
            $dto->body = $data['body'];
        }
        if (isset($data['mileage'])) {
            $dto->mileage = (int)$data['mileage'];
        }

        return $dto;
    }

}
