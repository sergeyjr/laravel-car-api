<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Статусы заказов:
     * pending_payment     → создан, ждёт оплаты
     * processing          → оплачен, в обработке
     * packed              → собран
     * shipped             → отправлен
     * completed           → завершён
     * cancelled           → отменён
     * refunded            → возвращён
     */

    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->decimal('total', 12, 2)->default(0);
            $table->string('status')->default('pending_payment');
            $table->string('payment_status')->nullable();
            $table->string('shipping_status')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }

};
