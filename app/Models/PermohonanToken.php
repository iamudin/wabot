<?php

namespace App\Models;

use App\Models\Layanan;
use Illuminate\Database\Eloquent\Model;

class PermohonanToken extends Model
{
    protected $fillable = [
        'phone',
        'layanan_id',
        'token',
        'used',
        'expired_at'
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'used' => 'boolean',
    ];

    public function isValid(): bool
    {
        return !$this->used && $this->expired_at->isFuture();
    }
      public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
}
