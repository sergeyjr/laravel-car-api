<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * php artisan test --filter AuthTest
 */
class AuthTest extends TestCase
{

    use RefreshDatabase;

    public function test_login_success()
    {
        User::factory()
            ->admin()
            ->password('123456')
            ->create([
                'email' => 'admin@test.com',
                'role' => 'api'
            ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'admin@test.com',
            'password' => '123456',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'api_token',
                    'message',
                ]
            ]);
    }

    public function test_login_wrong_password()
    {
        User::factory()
            ->admin()
            ->password('123456')
            ->create([
                'email' => 'admin@test.com',
                'role' => 'api'
            ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'admin@test.com',
            'password' => 'wrong',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'errors' => 'Неверные учетные данные'
            ]);
    }

    public function test_login_forbidden_for_regular_user()
    {
        User::factory()
            ->user()
            ->password('123456')
            ->create([
                'email' => 'user@test.com',
                'role' => ''
            ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'user@test.com',
            'password' => '123456',
        ]);

        $response->assertStatus(403)
            ->assertJson([
                'errors' => 'Запрещено: нет доступа к API'
            ]);
    }

    public function test_login_validation_error()
    {
        $response = $this->postJson('/api/v1/auth/login', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_session_token_requires_auth()
    {
        $response = $this->postJson('/api/v1/auth/session-token');

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Требуется авторизация.'
            ]);
    }

    public function test_protected_route_with_token()
    {
        $user = User::factory()
            ->admin()
            ->password('123456')
            ->create([
                'email' => 'admin@test.com',
                'role' => 'api'
            ]);

        $token = $user->createToken('api_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/v1/car/list');

        $response->assertOk();
    }

}
