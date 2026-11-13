<?php

namespace Tests\Feature;

use App\Models\CustomerAddress;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerAddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_view_address_list(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        CustomerAddress::factory()->create([
            'user_id' => $customer->id,
        ]);

        $response = $this->actingAs($customer)
            ->get(route('customer.addresses.index'));

        $response->assertOk();
        $response->assertViewIs('customer.addresses.index');
    }

    public function test_customer_can_create_address(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        $response = $this->actingAs($customer)
            ->post(route('customer.addresses.store'), [
                'label' => 'Rumah',
                'recipient_name' => 'Budi',
                'phone' => '081234567890',
                'address' => 'Jalan Merdeka No. 10',
                'latitude' => -8.5833,
                'longitude' => 116.1167,
            ]);

        $response->assertRedirect(route('customer.addresses.index'));

        $this->assertDatabaseHas('customer_addresses', [
            'user_id' => $customer->id,
            'label' => 'Rumah',
            'recipient_name' => 'Budi',
            'is_default' => true,
        ]);
    }

    public function test_first_address_is_automatically_default(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        $this->actingAs($customer)
            ->post(route('customer.addresses.store'), [
                'label' => 'Rumah',
                'recipient_name' => 'Budi',
                'phone' => '081234567890',
                'address' => 'Jalan Merdeka No. 10',
            ]);

        $this->assertDatabaseHas('customer_addresses', [
            'user_id' => $customer->id,
            'label' => 'Rumah',
            'is_default' => true,
        ]);
    }

    public function test_customer_can_update_own_address(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        $address = CustomerAddress::factory()->create([
            'user_id' => $customer->id,
            'label' => 'Rumah',
        ]);

        $response = $this->actingAs($customer)
            ->put(route('customer.addresses.update', $address->id), [
                'label' => 'Kantor',
                'recipient_name' => 'Budi',
                'phone' => '081234567890',
                'address' => 'Jalan Sudirman No. 20',
            ]);

        $response->assertRedirect(route('customer.addresses.index'));

        $this->assertDatabaseHas('customer_addresses', [
            'id' => $address->id,
            'user_id' => $customer->id,
            'label' => 'Kantor',
            'address' => 'Jalan Sudirman No. 20',
        ]);
    }

    public function test_customer_can_delete_own_address(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        $address = CustomerAddress::factory()->create([
            'user_id' => $customer->id,
        ]);

        $response = $this->actingAs($customer)
            ->delete(route('customer.addresses.destroy', $address->id));

        $response->assertRedirect(route('customer.addresses.index'));

        $this->assertDatabaseMissing('customer_addresses', [
            'id' => $address->id,
        ]);
    }

    public function test_customer_can_set_default_address(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        $firstAddress = CustomerAddress::factory()->create([
            'user_id' => $customer->id,
            'is_default' => true,
        ]);

        $secondAddress = CustomerAddress::factory()->create([
            'user_id' => $customer->id,
            'is_default' => false,
        ]);

        $response = $this->actingAs($customer)
            ->post(route('customer.addresses.default', $secondAddress->id));

        $response->assertRedirect(route('customer.addresses.index'));

        $this->assertDatabaseHas('customer_addresses', [
            'id' => $firstAddress->id,
            'is_default' => false,
        ]);

        $this->assertDatabaseHas('customer_addresses', [
            'id' => $secondAddress->id,
            'is_default' => true,
        ]);
    }

    public function test_customer_cannot_view_other_customer_address(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        $otherCustomer = User::factory()->create([
            'role' => 'customer',
        ]);

        $address = CustomerAddress::factory()->create([
            'user_id' => $otherCustomer->id,
        ]);

        $response = $this->actingAs($customer)
            ->get(route('customer.addresses.edit', $address->id));

        $response->assertNotFound();
    }

    public function test_customer_cannot_update_other_customer_address(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        $otherCustomer = User::factory()->create([
            'role' => 'customer',
        ]);

        $address = CustomerAddress::factory()->create([
            'user_id' => $otherCustomer->id,
        ]);

        $response = $this->actingAs($customer)
            ->put(route('customer.addresses.update', $address->id), [
                'label' => 'Alamat Diubah',
                'recipient_name' => 'Budi',
                'phone' => '081234567890',
                'address' => 'Alamat Baru',
            ]);

        $response->assertNotFound();

        $this->assertDatabaseMissing('customer_addresses', [
            'id' => $address->id,
            'label' => 'Alamat Diubah',
        ]);
    }

    public function test_customer_cannot_delete_other_customer_address(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        $otherCustomer = User::factory()->create([
            'role' => 'customer',
        ]);

        $address = CustomerAddress::factory()->create([
            'user_id' => $otherCustomer->id,
        ]);

        $response = $this->actingAs($customer)
            ->delete(route('customer.addresses.destroy', $address->id));

        $response->assertNotFound();

        $this->assertDatabaseHas('customer_addresses', [
            'id' => $address->id,
        ]);
    }

    public function test_guest_cannot_access_customer_addresses(): void
    {
        $response = $this->get(route('customer.addresses.index'));

        $response->assertRedirect(route('login'));
    }
}
