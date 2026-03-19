<?php

namespace App\DTO\Request;

use Illuminate\Http\Request;

class PaginationDTO
{
    public int $page = 1;
    public int $pageSize = 5;
    public ?string $sort = null;

    public function __construct(array $data = [])
    {
        $this->page = (int) ($data['page'] ?? $this->page);
        $this->pageSize = (int) ($data['pageSize'] ?? $this->pageSize);
        $this->sort = $data['sort'] ?? $this->sort;
    }

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }
}
