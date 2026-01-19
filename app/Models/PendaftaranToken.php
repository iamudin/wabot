<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranToken extends Model
{
    protected $fillable = [
        'phone',
        'token',
        'used',
        'expired_at'
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'used' => 'boolean'
    ];

    public function isValid()
    {
        return !$this->used && $this->expired_at->isFuture();
    }
}
