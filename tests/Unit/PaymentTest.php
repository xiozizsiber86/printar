<?php

namespace Tests\Unit;

use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_model_uses_correct_table(): void
    {
        $payment = new Payment();

        $this->assertEquals('payments', $payment->getTable());
    }

    public function test_payment_model_has_fillable_attributes(): void
    {
        $payment = new Payment();

        $this->assertContains('order_id', $payment->getFillable());
        $this->assertContains('method', $payment->getFillable());
        $this->assertContains('amount', $payment->getFillable());
        $this->assertContains('status', $payment->getFillable());
    }

    public function test_payment_belongs_to_order(): void
    {
        $payment = new Payment();

        $this->assertInstanceOf(
            BelongsTo::class,
            $payment->order()
        );
    }
}
