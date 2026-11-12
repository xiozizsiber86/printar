<?php

namespace Tests\Unit;

use App\Models\OrderFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class OrderFileTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_file_uses_correct_table(): void
    {
        $file = new OrderFile();

        $this->assertEquals('order_files', $file->getTable());
    }

    public function test_order_file_has_fillable_attributes(): void
    {
        $file = new OrderFile();

        $this->assertContains('order_item_id', $file->getFillable());
        $this->assertContains('original_name', $file->getFillable());
        $this->assertContains('file_path', $file->getFillable());
        $this->assertContains('mime_type', $file->getFillable());
        $this->assertContains('file_size', $file->getFillable());
    }

    public function test_order_file_belongs_to_order_item(): void
    {
        $file = new OrderFile();

        $this->assertInstanceOf(
            BelongsTo::class,
            $file->orderItem()
        );
    }
}
