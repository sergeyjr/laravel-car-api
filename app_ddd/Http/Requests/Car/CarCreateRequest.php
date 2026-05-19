<?php

namespace App\Http\Requests\Car;

use App\Application\Car\DTO\CarCreateInput;
use Illuminate\Foundation\Http\FormRequest;

class CarCreateRequest extends FormRequest
{

    public function rules(): array
    {
        $rules = [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'photo_url' => ['required', 'string'],
            'contacts' => ['required', 'string'],

            'options' => ['nullable', 'array'],
        ];

        if ($this->filled('options')) {
            $rules = array_merge($rules, [
                'options.brand' => ['required', 'string'],
                'options.model' => ['required', 'string'],
                'options.year' => ['required', 'integer'],
                'options.body' => ['required', 'string'],
                'options.mileage' => ['required', 'integer'],
            ]);
        }

        return $rules;
    }

    public function toDTO(): CarCreateInput
    {
        return new CarCreateInput(
            title: (string) $this->input('title'),
            description: (string) $this->input('description'),
            price: $this->input('price'),
            photo_url: $this->input('photo_url'),
            contacts: $this->input('contacts'),
            options: $this->input('options'),
        );
    }

}
