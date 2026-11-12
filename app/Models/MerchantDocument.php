<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MerchantDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'document_type',
        'file_path',
    ];

    // Relasi ke profil merchant
    public function merchantProfile(): BelongsTo
    {
        return $this->belongsTo(MerchantProfile::class, 'merchant_id');
    }
}
