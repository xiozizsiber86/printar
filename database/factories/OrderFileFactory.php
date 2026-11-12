<?php

namespace Database\Factories;

use App\Models\OrderFile;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderFile>
 */
class OrderFileFactory extends Factory
{
    public function definition(): array
    {
        $extension = fake()->randomElement(['pdf', 'jpg', 'png', 'docx']);

        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];

        return [
            'order_item_id' => OrderItem::factory(),
            'original_name' => fake()->word() . '.' . $extension,
            'file_path' => 'orders/files/' . fake()->uuid() . '.' . $extension,
            'mime_type' => $mimeTypes[$extension],
            'file_size' => fake()->numberBetween(10000, 5000000),
        ];
    }
}
