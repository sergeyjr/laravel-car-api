<?php

namespace App\Application\Car\DTO;

class CarOutput
{

    public int $id;
    public string $title;
    public string $description;
    public int|float|string|null $price;
    public string $photo_url;
    public string $contacts;

    public $options = null;

}
