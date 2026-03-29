<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\API\V1\Models\ApiUser;

class ApiUserSeeder extends Seeder
{

    /**
     * php artisan db:seed --class=ApiUserSeeder
     * @return void
     */
    public function run(): void
    {
        ApiUser::factory()->admin()->create();
        // ApiUser::factory()->count(5)->create();
    }

}
