<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'method' => fake()->randomElement([
                'manual_transfer',
                'payment_gateway',
            ]),
            'amount' => fake()->numberBetween(10000, 500000),
            'status' => 'pending',
            'proof_file' => null,
            'gateway_reference' => null,
            'verified_by' => null,
            'paid_at' => null,
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'failed',
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'notes' => 'Pembayaran ditolak oleh admin.',
        ]);
    }

    public function waitingVerification(): static
    {
        return $this->state(fn (array $attributes) => [
            'method' => 'manual_transfer',
            'status' => 'waiting_verification',
        ]);
    }
}
