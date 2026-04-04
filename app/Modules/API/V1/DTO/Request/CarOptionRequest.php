<?php

namespace Modules\API\V1\DTO\Request;

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
            $this->errors['brand'][] = 'Марка обязательна';
        }

        if (empty($this->model)) {
            $this->errors['model'][] = 'Модель обязательна';
        }

        if (empty($this->body)) {
            $this->errors['body'][] = 'Тип кузова обязателен';
        }

        if ($this->year <= 0) {
            $this->errors['year'][] = 'Год обязателен';
        }

        if ($this->year < 1885) {
            $this->errors['year'][] = 'Год должен быть >= 1885';
        }

        if ($this->mileage < 0) {
            $this->errors['mileage'][] = 'Пробег должен быть >= 0';
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
