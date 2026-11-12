<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'delivery_method',
        'courier_type',
        'courier_name',
        'courier_phone',
        'delivery_address',
        'delivery_fee',
        'shipped_at',
        'received_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'delivery_fee' => 'decimal:2',
            'shipped_at' => 'datetime',
            'received_at' => 'datetime',
        ];
    }

    // Relasi ke pesanan
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
