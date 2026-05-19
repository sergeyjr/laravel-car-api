<?php

namespace App\API\V1\DTO\Request;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarCreateRequest
{

    public string $title;
    public string $description;
    public int|float|string|null $price;
    public ?string $photo_url = null;
    public ?string $contacts = null;

    public ?array $options = null;

    public ?int $user_id = null;

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

        $dto->user_id = auth()->id();

        return $dto;
    }

    public function validate(): bool
    {
        $rules = [
            // car
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'photo_url' => ['required', 'string'],
            'contacts' => ['required', 'string'],

            // options
            'options' => ['nullable', 'array'],
        ];

        if (!empty($this->options)) {
            $rules = array_merge($rules, [
                'options.brand' => ['required', 'string'],
                'options.model' => ['required', 'string'],
                'options.year' => ['required', 'integer'],
                'options.body' => ['required', 'string'],
                'options.mileage' => ['required', 'integer'],
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
        return [
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'photo_url' => $this->photo_url,
            'contacts' => $this->contacts,
            'options' => $this->options,
            'user_id' => $this->user_id,
        ];
    }

}
