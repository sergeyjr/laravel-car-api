<?php

namespace App\Domain\Car;

class CarOption
{

    private int $id;
    private int $carId;
    private string $brand;
    private string $model;
    private int $year;
    private string $body;
    private int $mileage;

    public function __construct(
        int    $carId,
        string $brand,
        string $model,
        int    $year,
        string $body,
        int    $mileage
    )
    {
        $this->carId = $carId;
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
        $this->body = $body;
        $this->mileage = $mileage;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCarId(): int
    {
        return $this->carId;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getMileage(): int
    {
        return $this->mileage;
    }

    public static function fromState(array $state): self
    {
        return new self(
            carId: $state['car_id'],
            brand: $state['brand'],
            model: $state['model'],
            year: (int)$state['year'],
            body: $state['body'],
            mileage: (int)$state['mileage']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'car_id' => $this->carId,
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => $this->year,
            'body' => $this->body,
            'mileage' => $this->mileage,
        ];
    }

}
