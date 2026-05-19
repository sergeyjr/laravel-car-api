<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * php artisan test --filter CarListTest
 */
class CarListTest extends TestCase
{

    use RefreshDatabase;

    public function test_car_list_returns_paginated_result(): void
    {

        // 1. создаём юзера
        $user = User::factory()
            ->admin()
            ->password('123456')
            ->create([
                'email' => 'admin@test.com',
                'role' => 'api'
            ]);

        // 2. логин
        $login = $this->postJson('/api/v1/auth/login', [
            'email' => 'admin@test.com',
            'password' => '123456',
        ]);

        $login->assertStatus(200);

        $token = $login->json('data.api_token');

        // 3. создаём машины
        for ($i = 1; $i <= 3; $i++) {
            $this->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->postJson('/api/v1/car/create', [
                'title' => "CarModel $i",
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

        // 4. список
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/v1/car/list?page=1&perPage=2&sort=id&direction=desc');

        $this->debug($response);

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

        // 5. проверки пагинации
        $this->assertCount(2, $response->json('data.items'));
        $this->assertEquals(1, $response->json('data.page'));

    }

}

