<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * php artisan test --filter CarListTest
 */
class CarListTest extends TestCase
{

    // use RefreshDatabase; // achtung! полный сброс данных в бд!

    /**
     *  Автоматически считается тестом, потому что имя начинается с test
     *
     *  @return void
     */
    public function test_car_list_returns_paginated_result(): void
    {

        // 1. логин (получаем токен)
        $login = $this->postJson('/api/v1/auth/login', [
            'login' => 'admin',
            'password' => '123456',
        ]);

        $login->assertStatus(200);

        $token = $login->json('data.token');

        // 2. создаём 3 машины (чтобы было что листить)
        for ($i = 1; $i <= 3; $i++) {
            $this->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->postJson('/api/v1/car/create', [
                'title' => "Car $i",
                'description' => "Description $i",
                'price' => 10000 + $i,
                'photo_url' => "https://example.com/$i.jpg",
                'contacts' => "test$i@mail.com",
                'options' => [
                    [
                        'brand' => 'Brand',
                        'model' => 'Model',
                        'year' => 2020,
                        'body' => 'sedan',
                        'mileage' => 10000,
                    ]
                ]
            ])->assertStatus(201);
        }

        // 3. получаем список
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/v1/car/list?page=1&pageSize=2');

        // 4. проверки
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'success',
            'data' => [
                'items',
                'page',
                'total',
                'perPage',
            ],
        ]);

        // 5. логика пагинации
        $this->assertCount(2, $response->json('data.items'));
        $this->assertEquals(1, $response->json('data.page'));
    }

}
