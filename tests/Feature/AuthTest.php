<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * php artisan test --filter AuthTest
 */
class AuthTest extends TestCase
{

    public function test_login()
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'login' => 'admin',
            'password' => '123456'
        ]);

        $response->assertStatus(200);
    }

}
