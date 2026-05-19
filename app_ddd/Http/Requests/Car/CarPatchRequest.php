<?php

namespace App\Http\Requests\Car;

use App\Application\Car\DTO\CarPatchInput;
use App\Infrastructure\Persistence\Models\CarModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CarPatchRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string'],
            'price' => ['sometimes', 'numeric', 'min:0.01'],
            'photo_url' => ['sometimes', 'string'],
            'contacts' => ['sometimes', 'string'],

            'options' => ['sometimes', 'array'],

            'options.brand' => ['sometimes', 'string'],
            'options.model' => ['sometimes', 'string'],
            'options.year' => ['sometimes', 'integer'],
            'options.body' => ['sometimes', 'string'],
            'options.mileage' => ['sometimes', 'integer'],
        ];
    }

    public function toDTO(): CarPatchInput
    {
        return CarPatchInput::fromArray(
            array_filter($this->validated(), fn($v) => $v !== null)
        );
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {

            $carId = $this->route('id');

            $car = CarModel::with('option')->find($carId);

            if (!$car) {
                return;
            }

            if (!$car->option) {

                if (!$this->has('options')) {
                    $validator->errors()->add('options', 'Опции обязательны для заполнения.');
                    return;
                }

                foreach (['brand', 'model', 'year', 'body', 'mileage'] as $field) {
                    if (!$this->input("options.$field")) {
                        $validator->errors()->add(
                            "options.$field",
                            "Поле $field обязательно, так как опции создаются впервые."
                        );
                    }
                }
            }
        });
    }

}
