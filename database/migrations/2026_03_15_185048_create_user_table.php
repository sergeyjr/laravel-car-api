<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('login', 100)->unique();
            $table->string('password');
            $table->string('auth_token')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });

        DB::table('user')->insert([
            'login' => 'admin',
            'password' => Hash::make('123456'),
            'created_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
