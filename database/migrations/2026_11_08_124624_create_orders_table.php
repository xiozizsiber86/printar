<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->restrictOnDelete();

            $table->foreignId('shop_id')
                  ->constrained('shops')
                  ->restrictOnDelete();

            $table->foreignId('address_id')
                  ->nullable()
                  ->constrained('customer_addresses')
                  ->nullOnDelete();

            $table->string('order_number')->unique();

            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('delivery_fee', 12, 2)->default(0);
            $table->decimal('total_price', 12, 2)->default(0);

            $table->text('notes')->nullable();

            $table->enum('status', [
                'pending',
                'confirmed',
                'processing',
                'ready',
                'completed',
                'cancelled',
                'rejected'
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
