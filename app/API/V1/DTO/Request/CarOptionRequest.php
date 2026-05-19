<?php

namespace App\API\V1\DTO\Request;

use Illuminate\Support\Facades\Validator;

class CarOptionRequest
{

    public ?string $brand = null;
    public ?string $model = null;
    public ?int $year = null;
    public ?string $body = null;
    public ?int $mileage = null;

    public array $errors = [];

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
