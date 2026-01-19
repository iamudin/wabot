<?php

namespace App\Models;

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
}
