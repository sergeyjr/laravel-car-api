<?php

namespace Modules\API\V1\DTO\Request;

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

    public array $errors = [];

    public static function fromRequest(Request $request): self
    {
        $dto = new self();

        $dto->title = (string) $request->input('title', '');
        $dto->description = (string) $request->input('description', '');
        $dto->price = $request->input('price');
        $dto->photo_url = $request->input('photo_url');
        $dto->contacts = $request->input('contacts');
        $dto->options = $request->input('options');

        return $dto;
    }

    public function validate(): bool
    {
        $validator = Validator::make($this->toArray(), [
            // car
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0.01'],
            'photo_url' => ['required', 'string'],
            'contacts' => ['required', 'string'],
            // car options
            'options' => ['nullable', 'array'],
            'options.*.brand' => ['required_with:options', 'string'],
            'options.*.model' => ['required_with:options', 'string'],
            'options.*.year' => ['required_with:options', 'integer'],
            'options.*.body' => ['required_with:options', 'string'],
            'options.*.mileage' => ['required_with:options', 'integer'],
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
