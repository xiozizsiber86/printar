<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MerchantProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'verification_status',
        'verified_by',
        'verified_at',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
        ];
    }

    // Relasi ke pemilik akun merchant
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke admin yang memverifikasi merchant
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Relasi ke dokumen merchant
    public function documents(): HasMany
    {
        return $this->hasMany(MerchantDocument::class, 'merchant_id');
    }

    // Relasi ke toko milik merchant
    public function shops(): HasMany
    {
        return $this->hasMany(Shop::class, 'merchant_id');
    }
}
