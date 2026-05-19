<?php

use Database\Seeders\CarSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {

        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 12, 2);
            $table->string('photo_url');
            $table->string('contacts');
            $table->timestamps(); // created_at, updated_at
        });

        Schema::create('cars_option', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_id')->unique();
            $table->string('brand', 100);
            $table->string('model', 100);
            $table->integer('year');
            $table->string('body', 100);
            $table->integer('mileage');
            $table->foreign('car_id')
                ->references('id')
                ->on('car')
                ->cascadeOnDelete();
        });

        Artisan::call('db:seed', [
            '--class' => CarSeeder::class,
        ]);

    }

    public function down(): void
    {
        Schema::dropIfExists('cars_option');
        Schema::dropIfExists('cars');
    }

};
