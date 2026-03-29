<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarSeeder extends Seeder
{

    public function run(): void
    {

        $cars = [
            ['BMW X5', 'Comfortable SUV', 25000, 'SUV'],
            ['BMW X3', 'Compact premium SUV', 22000, 'SUV'],
            ['Audi A4', 'German sedan', 18000, 'Sedan'],
            ['Audi Q5', 'Luxury crossover', 27000, 'SUV'],
            ['Toyota Camry', 'Reliable sedan', 15000, 'Sedan'],
            ['Toyota RAV4', 'Popular SUV', 20000, 'SUV'],
            ['Honda Civic', 'Compact car', 12000, 'Sedan'],
            ['Honda CR-V', 'Family SUV', 21000, 'SUV'],
            ['Mercedes C200', 'Premium sedan', 22000, 'Sedan'],
            ['Mercedes GLC', 'Luxury SUV', 30000, 'SUV'],
            ['Volkswagen Passat', 'Business sedan', 16000, 'Sedan'],
            ['Skoda Octavia', 'Practical liftback', 14000, 'Liftback'],
            ['Kia Sportage', 'Modern SUV', 17000, 'SUV'],
            ['Hyundai Tucson', 'Family SUV', 17500, 'SUV'],
            ['Tesla Model 3', 'Electric sedan', 35000, 'Sedan'],
        ];

        foreach ($cars as $car) {
            $carId = DB::table('car')->insertGetId([
                'title' => $car[0],
                'description' => $car[1],
                'price' => $car[2],
                'photo_url' => null,
                'contacts' => 'admin@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            [$brand, $model] = explode(' ', $car[0]) + [null, null];

            DB::table('car_option')->insert([
                'car_id' => $carId,
                'brand' => $brand,
                'model' => $model,
                'year' => 2020,
                'body' => $car[3],
                'mileage' => 50000,
            ]);
        }

    }

}
