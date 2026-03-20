<?php

namespace Database\Seeders;

use App\Models\ApiUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ApiUser::factory(10)->create();

        ApiUser::factory()->create([
            'name' => 'Test ApiUser',
            'email' => 'test@example.com',
        ]);
    }
}
