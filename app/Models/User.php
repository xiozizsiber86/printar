<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Memeriksa role admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Memeriksa role customer
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    // Memeriksa role merchant
    public function isMerchant(): bool
    {
        return $this->role === 'merchant';
    }

    // Relasi ke profil merchant
    public function merchantProfile(): HasOne
    {
        return $this->hasOne(MerchantProfile::class);
    }

    // Relasi ke alamat pelanggan
    public function customerAddresses(): HasMany
    {
        return $this->hasMany(CustomerAddress::class);
    }

    // Relasi ke keranjang belanja
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class, 'user_id');
    }

    // Relasi ke pesanan
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // Relasi ke pembayaran yang diverifikasi
    public function verifiedPayments(): HasMany
    {
        return $this->hasMany(Payment::class, 'verified_by');
    }

    // Relasi ke riwayat perubahan status
    public function changedOrderStatuses(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class, 'changed_by');
    }
}
