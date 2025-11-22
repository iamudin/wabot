<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SyaratLayanan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'layanan_id',
        'nama',
        'keterangan',
        'jenis_syarat',
        'status',
        'urutan',
        'sumber_data',
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
            'layanan_id' => 'integer',
            'status' => 'boolean',
            'urutan' => 'integer',
        ];
    }

    public function dataPermohonans(): HasMany
    {
        return $this->hasMany(DataPermohonan::class);
    }

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }
}
