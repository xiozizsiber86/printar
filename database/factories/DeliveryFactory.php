<?php

namespace Database\Factories;

use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Delivery>
 */
class DeliveryFactory extends Factory
{
    public function definition(): array
    {
        $deliveryMethod = fake()->randomElement([
            'delivery',
            'pickup',
        ]);

        return [
            'order_id' => Order::factory(),
            'delivery_method' => $deliveryMethod,
            'courier_type' => $deliveryMethod === 'delivery'
                ? 'merchant'
                : null,
            'courier_name' => $deliveryMethod === 'delivery'
                ? fake()->name()
                : null,
            'courier_phone' => $deliveryMethod === 'delivery'
                ? fake()->phoneNumber()
                : null,
            'delivery_address' => $deliveryMethod === 'delivery'
                ? fake()->address()
                : null,
            'delivery_fee' => $deliveryMethod === 'delivery'
                ? fake()->numberBetween(3000, 20000)
                : 0,
            'shipped_at' => null,
            'received_at' => null,
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function pickup(): static
    {
        return $this->state(fn (array $attributes) => [
            'delivery_method' => 'pickup',
            'courier_type' => null,
            'courier_name' => null,
            'courier_phone' => null,
            'delivery_address' => null,
            'delivery_fee' => 0,
        ]);
    }

    public function delivered(): static
    {
        return $this->state(fn (array $attributes) => [
            'shipped_at' => now()->subHour(),
            'received_at' => now(),
        ]);
    }
}
