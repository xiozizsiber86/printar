<?php

namespace Database\Factories;

use App\Models\Shop;
use App\Models\MerchantProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Shop>
 */
class ShopFactory extends Factory
{
    public function definition(): array
    {
        return [
            'merchant_id' => MerchantProfile::factory(),
            'name' => fake()->company() . ' Printing',
            'description' => fake()->sentence(),
            'address' => fake()->address(),
            'latitude' => fake()->latitude(-8.7, -8.4),
            'longitude' => fake()->longitude(115.9, 116.3),
            'phone' => fake()->phoneNumber(),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
