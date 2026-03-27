<?php

namespace Modules\API\V1\DTO\Request;

use Illuminate\Http\Request;

class CarOptionRequest
{

    public string $brand;
    public string $model;
    public int $year;
    public string $body;
    public int $mileage;

    public array $errors = [];

    public static function fromArray(array $data): self
    {
        $dto = new self();

        $dto->brand = $data['brand'] ?? '';
        $dto->model = $data['model'] ?? '';
        $dto->year = (int) ($data['year'] ?? 0);
        $dto->body = $data['body'] ?? '';
        $dto->mileage = (int) ($data['mileage'] ?? 0);

        return $dto;
    }

    public function validate(): bool
    {
        $this->errors = [];

        if (empty($this->brand)) {
            $this->errors['brand'][] = 'Brand is required';
        }

        if (empty($this->model)) {
            $this->errors['model'][] = 'Model is required';
        }

        if (empty($this->body)) {
            $this->errors['body'][] = 'Body is required';
        }

        if ($this->year <= 0) {
            $this->errors['year'][] = 'Year is required';
        }

        if ($this->year < 1885) {
            $this->errors['year'][] = 'Year must be >= 1885';
        }

        if ($this->mileage < 0) {
            $this->errors['mileage'][] = 'Mileage must be >= 0';
        }

        return empty($this->errors);
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
