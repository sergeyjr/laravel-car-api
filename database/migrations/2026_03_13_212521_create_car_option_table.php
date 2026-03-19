<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('car_option', function (Blueprint $table) {
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

        DB::statement("
            ALTER TABLE car_option
            ADD CONSTRAINT chk_car_option_year CHECK (year >= 1885)
        ");

        DB::statement("
            ALTER TABLE car_option
            ADD CONSTRAINT chk_car_option_mileage CHECK (mileage >= 0)
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('car_option');
    }
};
