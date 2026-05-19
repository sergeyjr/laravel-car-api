<?php

namespace App\Domain\Car;

class Car
{

    private int $id;
    private string $title;
    private string $description;
    private float $price;
    private ?string $photoUrl;
    private ?string $contacts;

    public function __construct(
        string  $title,
        string  $description,
        float   $price,
        ?string $photoUrl = null,
        ?string $contacts = null
    )
    {
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setPrice($price);
        $this->photoUrl = $photoUrl;
        $this->contacts = $contacts;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getPhotoUrl(): ?string
    {
        return $this->photoUrl;
    }

    public function getContacts(): ?string
    {
        return $this->contacts;
    }

    public function setTitle(string $title): void
    {
        if (empty($title)) {
            throw new \InvalidArgumentException('Название автомобиля не может быть пустым.');
        }
        $this->title = $title;
    }

    private function setDescription(string $description)
    {
        if (empty($title)) {
            throw new \InvalidArgumentException('Описание автомобиля не может быть пустым.');
        }
        $this->description = $description;
    }

    private function setPrice(float $price)
    {
        if (empty($title)) {
            throw new \InvalidArgumentException('Цена автомобиля не может быть пустым.');
        }
        $this->price = $price;
    }

    /**
     * Создает Сущность из массива данных (обычно из Eloquent)
     */
    public static function fromState(array $state): self
    {
        $car = new self(
            title: $state['title'],
            description: $state['description'],
            price: $state['price'],
            photoUrl: $state['photo_url'] ?? null,
            contacts: $state['contacts'] ?? null
        );

        $car->id = $state['id'];

        return $car;
    }

    /**
     * Преобразует Сущность в массив для сохранения в БД
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'photo_url' => $this->photoUrl,
            'contacts' => $this->contacts,
        ];
    }

}
