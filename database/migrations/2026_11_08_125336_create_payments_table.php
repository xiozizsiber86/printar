<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                  ->unique()
                  ->constrained('orders')
                  ->cascadeOnDelete();

            $table->enum('method', [
                'manual_transfer',
                'payment_gateway'
            ]);

            $table->decimal('amount', 12, 2);

            $table->enum('status', [
                'pending',
                'waiting_verification',
                'paid',
                'failed',
                'rejected',
                'expired',
                'refunded'
            ])->default('pending');

            $table->string('proof_file')->nullable();
            $table->string('gateway_reference')->nullable();

            $table->foreignId('verified_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
