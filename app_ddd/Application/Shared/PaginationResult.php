<?php

namespace App\Application\Shared;

class PaginationResult implements \JsonSerializable
{

    public function __construct(
        public readonly array $items,
        public readonly int   $page,
        public readonly int   $total,
        public readonly int   $perPage,
        public readonly int   $lastPage,
    )
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'data' => $this->items,
            'current_page' => $this->page,
            'last_page' => $this->lastPage,
            'total' => $this->total,
            'per_page' => $this->perPage,
        ];
    }

}
