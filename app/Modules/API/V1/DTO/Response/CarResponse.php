<?php

namespace Modules\API\V1\DTO\Response;

class CarResponse
{

    public int $id;
    public string $title;
    public string $description;
    public float $price;
    public string $photo_url;
    public string $contacts;

    public ?array $options = null;

}
