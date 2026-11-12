<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItem>
 */
class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $service = Service::factory()->create();
        $quantity = fake()->numberBetween(1, 100);
        $price = $service->price;

        return [
            'order_id' => Order::factory(),
            'service_id' => $service->id,
            'service_name' => $service->name,
            'price' => $price,
            'unit' => $service->unit,
            'quantity' => $quantity,
            'subtotal' => $price * $quantity,
        ];
    }
}
