<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Modules\API\V1\Models\ApiUser;

class ApiUserFactory extends Factory
{

    protected $model = ApiUser::class;

    public function definition(): array
    {
        return [
            'login' => fake()->unique()->userName(),
            'password' => Hash::make('123456'),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => [
            'login' => 'admin',
            'password' => Hash::make('123456'),
        ]);
    }

}
