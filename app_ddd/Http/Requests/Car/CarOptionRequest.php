<?php

namespace App\Http\Requests\Car;

use App\Application\Car\DTO\CarOptionInput;
use Illuminate\Foundation\Http\FormRequest;

class CarOptionRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'brand' => ['nullable', 'string'],
            'model' => ['nullable', 'string'],
            'year' => ['nullable', 'integer'],
            'body' => ['nullable', 'string'],
            'mileage' => ['nullable', 'integer'],
        ];
    }

    public function toDTO(): CarOptionInput
    {
        return CarOptionInput::fromArray($this->validated());
    }

}
