<?php

use Database\Seeders\ApiUserSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {

        Schema::create('api_user', function (Blueprint $table) {
            $table->id();
            $table->string('login', 100)->unique();
            $table->string('password');
            $table->string('auth_token')->nullable();
            $table->timestamps(); // created_at, updated_at
        });

        Artisan::call('db:seed', [
            '--class' => ApiUserSeeder::class,
        ]);

    }

    public function down(): void
    {
        Schema::dropIfExists('api_user');
    }

};
