<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class OrderStatusHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_history_model_uses_correct_table(): void
    {
        $history = new OrderStatusHistory();

        $this->assertEquals('order_status_histories', $history->getTable());
    }

    public function test_history_model_has_fillable_attributes(): void
    {
        $history = new OrderStatusHistory();

        $this->assertContains('order_id', $history->getFillable());
        $this->assertContains('changed_by', $history->getFillable());
        $this->assertContains('status', $history->getFillable());
        $this->assertContains('notes', $history->getFillable());
    }

    public function test_history_belongs_to_order(): void
    {
        $history = new OrderStatusHistory();

        $this->assertInstanceOf(
            BelongsTo::class,
            $history->order()
        );
    }

    public function test_history_belongs_to_user(): void
    {
        $history = new OrderStatusHistory();

        $this->assertInstanceOf(
            BelongsTo::class,
            $history->changedBy()
        );
    }

    public function test_history_can_be_saved_to_database(): void
    {
        $history = OrderStatusHistory::factory()->create();

        $this->assertDatabaseHas('order_status_histories', [
            'id' => $history->id,
            'order_id' => $history->order_id,
            'changed_by' => $history->changed_by,
            'status' => $history->status,
        ]);
    }

    public function test_history_is_connected_to_order_and_user(): void
    {
        $history = OrderStatusHistory::factory()->create();

        $this->assertInstanceOf(Order::class, $history->order);
        $this->assertInstanceOf(User::class, $history->changedBy);
    }
}
