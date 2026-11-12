<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Shop;
use App\Models\CustomerAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        $subtotal = fake()->numberBetween(10000, 500000);
        $deliveryFee = fake()->numberBetween(0, 20000);

        return [
            'user_id' => User::factory(),
            'shop_id' => Shop::factory(),
            'address_id' => CustomerAddress::factory(),
            'order_number' => 'PRT-' . now()->format('Ymd') . '-' . fake()->unique()->numerify('#####'),
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee,
            'total_price' => $subtotal + $deliveryFee,
            'notes' => fake()->optional()->sentence(),
            'status' => 'pending',
        ];
    }

    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }

    public function processing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'processing',
        ]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }
}
