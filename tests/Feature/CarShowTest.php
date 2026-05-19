<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * php artisan test --filter CarShowTest
 */
class CarShowTest extends TestCase
{

    use RefreshDatabase;

    public function test_get_car_by_id_returns_car_with_options(): void
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

        // 3. создаём машину
        $create = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
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

        $carId = $create->json('data.id');

        // 4. запрос по id
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->getJson("/api/v1/car/" . $carId);

        $this->debug($response);

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

}
