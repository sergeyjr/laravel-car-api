<?php

namespace App\Application\Car\DTO;

class CarOptionInput
{

    public ?string $brand = null;
    public ?string $model = null;
    public ?int $year = null;
    public ?string $body = null;
    public ?int $mileage = null;

    public static function fromArray(array $data): self
    {
        $dto = new self();

        if (isset($data['brand'])) {
            $dto->brand = (string)$data['brand'];
        }

        if (isset($data['model'])) {
            $dto->model = (string)$data['model'];
        }

        if (isset($data['year'])) {
            $dto->year = (int)$data['year'];
        }

        if (isset($data['body'])) {
            $dto->body = (string)$data['body'];
        }

        if (isset($data['mileage'])) {
            $dto->mileage = (int)$data['mileage'];
        }

        return $dto;
    }

    public function toArray(): array
    {
        return [
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => $this->year,
            'body' => $this->body,
            'mileage' => $this->mileage,
        ];
    }

}
