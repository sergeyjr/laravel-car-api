<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiUserSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('api_user')->updateOrInsert(
            ['login' => 'admin'],
            [
                'password' => Hash::make('123456'),
                'created_at' => now(),
            ]
        );
    }

}
