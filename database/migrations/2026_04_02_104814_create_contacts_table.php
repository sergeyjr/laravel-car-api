<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id(); // bigint primary key
            $table->string('name');
            $table->string('email');
            $table->string('subject');
            $table->text('body');
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }

};
