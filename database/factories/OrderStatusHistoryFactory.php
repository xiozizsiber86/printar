<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderStatusHistory>
 */
class OrderStatusHistoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'changed_by' => User::factory(),
            'status' => fake()->randomElement([
                'pending',
                'confirmed',
                'processing',
                'ready',
                'completed',
                'cancelled',
                'rejected',
            ]),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
