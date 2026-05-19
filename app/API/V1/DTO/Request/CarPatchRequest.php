<?php

namespace App\API\V1\DTO\Request;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarPatchRequest
{

    public ?string $title = null;
    public ?string $description = null;
    public $price = null;
    public ?string $photo_url = null;
    public ?string $contacts = null;

    public ?array $options = null;

    public array $errors = [];

    public static function fromRequest(Request $request): self
    {
        $dto = new self();

        $dto->title = $request->has('title') ? (string)$request->input('title') : null;
        $dto->description = $request->has('description') ? (string)$request->input('description') : null;
        $dto->price = $request->has('price') ? $request->input('price') : null;
        $dto->photo_url = $request->has('photo_url') ? (string)$request->input('photo_url') : null;
        $dto->contacts = $request->has('contacts') ? (string)$request->input('contacts') : null;

        $dto->options = $request->has('options') ? $request->input('options') : null;

        return $dto;
    }

    public function validate(): bool
    {
        $rules = [
            // car
            'title' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string'],
            'price' => ['sometimes', 'numeric', 'min:0.01'],
            'photo_url' => ['sometimes', 'string'],
            'contacts' => ['sometimes', 'string'],

            // options
            'options' => ['sometimes', 'array'],
        ];

        if (!empty($this->options)) {
            $rules = array_merge($rules, [
                'options.brand' => ['sometimes', 'string'],
                'options.model' => ['sometimes', 'string'],
                'options.year' => ['sometimes', 'integer'],
                'options.body' => ['sometimes', 'string'],
                'options.mileage' => ['sometimes', 'integer'],
            ]);
        }

        $validator = Validator::make($this->toArray(), $rules);

        if ($validator->fails()) {
            $this->errors = $validator->errors()->toArray();
            return false;
        }

        return true;
    }

    public function toArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'photo_url' => $this->photo_url,
            'contacts' => $this->contacts,
            'options' => $this->options,
        ], fn($v) => $v !== null);
    }

}
