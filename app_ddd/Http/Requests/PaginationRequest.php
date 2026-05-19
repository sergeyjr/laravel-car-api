<?php

namespace App\Http\Requests;

use App\Domain\Shared\Pagination;
use Illuminate\Foundation\Http\FormRequest;

class PaginationRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'perPage' => ['nullable', 'integer', 'min:1', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
            'sort' => ['nullable', 'string'],
        ];
    }

    public function toDTO(): Pagination
    {
        return new Pagination(
            page: (int)$this->input('page', 1),
            perPage: (int)$this->input('perPage', 10),
            sort: $this->input('sort', '-id'),
        );
    }

}
