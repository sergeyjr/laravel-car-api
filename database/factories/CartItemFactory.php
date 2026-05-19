<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{

    public function definition(): array
    {
        return [
            'cart_id' => null,
            'car_id' => null,
            'qty' => 1,
            'price' => $this->faker->numberBetween(1000, 100000),
        ];
    }

}
