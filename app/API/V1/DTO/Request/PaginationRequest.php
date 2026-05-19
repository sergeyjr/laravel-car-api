<?php

namespace App\API\V1\DTO\Request;

use Illuminate\Http\Request;

class PaginationRequest
{

    public int $page = 1;
    public int $perPage = 5;
    public ?string $sort = null;
    public string $direction = 'desc';

    public function __construct(array $data = [])
    {
        $this->page = (int) ($data['page'] ?? $this->page);
        $this->perPage = (int) ($data['perPage'] ?? $this->perPage);
        $this->sort = $data['sort'] ?? null;
        $this->direction = strtolower($data['direction'] ?? 'asc');
    }

    public static function fromRequest(Request $request): self
    {
        return new self($request->query());
    }

}
