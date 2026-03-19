<?php

namespace App\DTO\Response;

class CarListResponse
{
    public array $items = [];
    public int $page;
    public int $total;
    public int $perPage;

    public function __construct(array $items, int $page, int $total, int $perPage)
    {
        $this->items = $items;
        $this->page = $page;
        $this->total = $total;
        $this->perPage = $perPage;
    }
}
