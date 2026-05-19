<?php

namespace App\Application\Car\DTO;

class CarPatchInput
{

    public ?string $title = null;
    public ?string $description = null;
    public ?float $price = null;
    public ?string $photo_url = null;
    public ?string $contacts = null;

    public ?array $options = null;

    public static function fromArray(array $data): self
    {
        $dto = new self();

        $dto->title = $data['title'] ?? null;
        $dto->description = $data['description'] ?? null;
        $dto->price = isset($data['price']) ? (float)$data['price'] : null;
        $dto->photo_url = $data['photo_url'] ?? null;
        $dto->contacts = $data['contacts'] ?? null;

        $dto->options = $data['options'] ?? null;

        return $dto;
    }

    public function toArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'photo_url' => $this->photo_url,
            'contacts' => $this->contacts,
            'options' => $this->options,
        ], fn($v) => $v !== null);
    }

}
