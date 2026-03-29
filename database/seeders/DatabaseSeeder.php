<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * php artisan migrate --seed
     * php artisan db:seed
     * php artisan db:seed --class=ApiUserSeeder
     * php artisan db:seed --class=CarSeeder
     * @return void
     */
    public function run(): void
    {
        $this->call([
            ApiUserSeeder::class,
            CarSeeder::class,
        ]);
    }

}
