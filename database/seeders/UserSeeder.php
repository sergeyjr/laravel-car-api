<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    /**
     * php artisan db:seed --class=UserSeeder
     * @return void
     */
    public function run(): void
    {
        User::factory()->count(10)->create();
    }

}
