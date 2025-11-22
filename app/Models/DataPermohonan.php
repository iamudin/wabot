<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataPermohonan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permohonan_id',
        'syarat_layanan_id',
        'keterangan',
        'koreksidata',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'permohonan_id' => 'integer',
            'syarat_layanan_id' => 'integer',
        ];
    }

    public function permohonan(): BelongsTo
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function syaratLayanan(): BelongsTo
    {
        return $this->belongsTo(SyaratLayanan::class);
    }
}
