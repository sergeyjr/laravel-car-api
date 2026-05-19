<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->unsignedBigInteger('user_id');
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('contacts');
            $table->timestamps(); // created_at, updated_at
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }

};
