<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_can_be_created_with_pending_status(): void
    {
        $payment = Payment::factory()->create();

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => 'pending',
        ]);
    }

    public function test_payment_can_have_paid_status(): void
    {
        $payment = Payment::factory()->paid()->create();

        $this->assertEquals('paid', $payment->status);
        $this->assertNotNull($payment->paid_at);
    }

    public function test_payment_can_have_failed_status(): void
    {
        $payment = Payment::factory()->failed()->create();

        $this->assertEquals('failed', $payment->status);
    }

    public function test_payment_can_have_rejected_status(): void
    {
        $payment = Payment::factory()->rejected()->create();

        $this->assertEquals('rejected', $payment->status);
        $this->assertEquals(
            'Pembayaran ditolak oleh admin.',
            $payment->notes
        );
    }

    public function test_payment_can_have_waiting_verification_status(): void
    {
        $payment = Payment::factory()->waitingVerification()->create();

        $this->assertEquals('waiting_verification', $payment->status);
        $this->assertEquals('manual_transfer', $payment->method);
    }

    public function test_payment_can_have_expired_status(): void
    {
        $payment = Payment::factory()->expired()->create();

        $this->assertEquals('expired', $payment->status);
    }

    public function test_payment_can_have_refunded_status(): void
    {
        $payment = Payment::factory()->refunded()->create();

        $this->assertEquals('refunded', $payment->status);
    }

    public function test_order_cannot_have_multiple_payments(): void
    {
        $order = Order::factory()->create();

        Payment::factory()->create([
            'order_id' => $order->id,
        ]);

        $this->expectException(QueryException::class);

        Payment::factory()->create([
            'order_id' => $order->id,
        ]);
    }
}
