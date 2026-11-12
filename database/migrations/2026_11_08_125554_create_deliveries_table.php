<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                  ->unique()
                  ->constrained('orders')
                  ->cascadeOnDelete();

            $table->enum('delivery_method', [
                'delivery',
                'pickup'
            ]);

            $table->enum('courier_type', [
                'merchant',
                'third_party'
            ])->nullable();

            $table->string('courier_name')->nullable();
            $table->string('courier_phone', 20)->nullable();

            $table->text('delivery_address')->nullable();

            $table->decimal('delivery_fee', 12, 2)->default(0);

            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('received_at')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
