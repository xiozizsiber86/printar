<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'address_id',
        'order_number',
        'subtotal',
        'delivery_fee',
        'total_price',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'delivery_fee' => 'decimal:2',
            'total_price' => 'decimal:2',
        ];
    }

    // Relasi ke pelanggan
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke toko
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    // Relasi ke alamat pelanggan
    public function address(): BelongsTo
    {
        return $this->belongsTo(CustomerAddress::class, 'address_id');
    }

    // Relasi ke item pesanan
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    // Relasi ke pembayaran
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'order_id');
    }

    // Relasi ke pengiriman
    public function delivery(): HasOne
    {
        return $this->hasOne(Delivery::class, 'order_id');
    }

    // Relasi ke riwayat status pesanan
    public function statusHistories(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class, 'order_id');
    }
}

