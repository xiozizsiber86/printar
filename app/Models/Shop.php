<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'name',
        'description',
        'address',
        'latitude',
        'longitude',
        'phone',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_active' => 'boolean',
        ];
    }

    // Relasi ke profil merchant
    public function merchantProfile(): BelongsTo
    {
        return $this->belongsTo(MerchantProfile::class, 'merchant_id');
    }

    // Relasi ke layanan percetakan
    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'shop_id');
    }

    // Relasi ke pesanan
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'shop_id');
    }
}
