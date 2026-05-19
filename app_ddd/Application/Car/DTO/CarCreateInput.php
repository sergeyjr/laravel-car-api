<?php

namespace App\Application\Car\DTO;

class CarCreateInput
{

    public function __construct(
        public readonly string    $title,
        public readonly string    $description,
        public readonly float|int $price,
        public readonly ?string   $photo_url = null,
        public readonly ?string   $contacts = null,
        public readonly ?array    $options = null,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'photo_url' => $this->photo_url,
            'contacts' => $this->contacts,
            'options' => $this->options,
        ];
    }

}
