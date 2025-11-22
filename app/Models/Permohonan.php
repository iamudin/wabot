<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permohonan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'layanan_id',
        'sesi_dimulai',
        'sesi_berakir',
        'status_permohonan',
        'penduduk_id',
        'pemohon_id',
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
            'sesi_dimulai' => 'timestamp',
            'sesi_berakir' => 'timestamp',
            'penduduk_id' => 'integer',
            'pemohon_id' => 'integer',
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

    public function penduduk(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function pemohon(): BelongsTo
    {
        return $this->belongsTo(Penduduk::class);
    }
}
