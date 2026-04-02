<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * php artisan test --filter CarShowTest
 */
class CarShowTest extends TestCase
{

    public function test_get_car_by_id_returns_car_with_options(): void
    {

        // 1. логин
        $login = $this->postJson('/api/v1/auth/login', [
            'login' => 'admin',
            'password' => '123456',
        ]);

        $login->assertStatus(200);

        $token = $login->json('data.token');

        // 2. создаём машину
        $create = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/v1/car/create', [
            'title' => 'Audi A4',
            'description' => 'German sedan',
            'price' => 18000,
            'photo_url' => 'https://example.com/audi.jpg',
            'contacts' => 'admin@example.com',
            'options' => [
                [
                    'brand' => 'Audi',
                    'model' => 'A4',
                    'year' => 2018,
                    'body' => 'sedan',
                    'mileage' => 120000,
                ]
            ]
        ]);

        $create->assertStatus(201);

        // 3. берем id созданной машины
        $carId = $this->getCarId($token);

        // 4. запрос по id
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson("/api/v1/car/{$carId}");

        // 5. проверки
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'success',
            'data' => [
                'id',
                'title',
                'description',
                'price',
                'photo_url',
                'contacts',
                'options',
            ],
        ]);

        $this->assertEquals('Audi A4', $response->json('data.title'));

        $this->assertNotEmpty($response->json('data.options'));

    }

    private function getCarId(string $token): int
    {
        $list = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/v1/car/list');

        return $list->json('data.items.0.id');
    }

}
