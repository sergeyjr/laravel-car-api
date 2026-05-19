<?php

namespace App\Http\Requests\Car;

use App\Application\Car\DTO\CarUpdateInput;
use Illuminate\Foundation\Http\FormRequest;

class CarUpdateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'photo_url' => ['required', 'string'],
            'contacts' => ['required', 'string'],

            'options' => ['nullable', 'array'],

            'options.brand' => ['required_with:options', 'string'],
            'options.model' => ['required_with:options', 'string'],
            'options.year' => ['required_with:options', 'integer'],
            'options.body' => ['required_with:options', 'string'],
            'options.mileage' => ['required_with:options', 'integer'],
        ];
    }

    public function toDTO(): CarUpdateInput
    {
        return CarUpdateInput::fromArray($this->validated());
    }

}
