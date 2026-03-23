<?php

namespace App\DTO\Request;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateCarDTO
{
    public string $title;
    public string $description;
    public float $price;
    public string $photo_url;
    public string $contacts;
    public ?array $options = null;

    public array $errors = [];

    public static function fromRequest(Request $request): self
    {
        $dto = new self();

        $dto->title = $request->input('title');
        $dto->description = $request->input('description');
        $dto->price = (float) $request->input('price');
        $dto->photo_url = $request->input('photo_url');
        $dto->contacts = $request->input('contacts');
        $dto->options = $request->input('options');

        return $dto;
    }

    public function validate(): bool
    {
        $validator = Validator::make($this->toArray(), [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'photo_url' => ['required', 'string'],
            'contacts' => ['required', 'string'],
            'options' => ['nullable', 'array', 'list'],
        ]);

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
        ];
    }
}
