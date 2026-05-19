<?php

namespace App\API\V1\DTO\Response;

class CarResponse
{

    public int $id;
    public string $title;
    public string $description;
    public int|float|string|null $price;
    public string $photo_url;
    public string $contacts;

    public ?int $user_id = null;

    public $options = null;

}
