<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'diajukan_pada',
        'hasil_docx',
        'kode_tiket',
        'surat_tte',
        'ditandatangani_pada'
    ];
    public static function booted()
    {
        static::deleting(function ($model) {
            // Hapus relasi
            $model->dataPermohonans()->delete();
        });
    }
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
            'diproses_pada'=>'datetime',
            'ditolak_pada' => 'datetime',
            'ditandatangani_pada' => 'datetime',
            'diselesaikan_pada' => 'datetime',
            'penduduk_id' => 'integer',
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

 

    public function penandatangan(): BelongsTo
    {
        return $this->belongsTo(Penandatangan::class);
    }
}
