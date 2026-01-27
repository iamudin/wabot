<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penduduk extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nik',
        'nama',
        'jenis_kelamin',
        'file_ktp',
        'alamat',
        'rt',
        'rw',
        'pekerjaan',
        'kewarganegaraan',
        'agama',
        'status_kawin',
        'nomor_whatsapp',
        'terdaftar_pada',
        'terverifikasi_pada',
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
            'rt_id' => 'integer',
            'file_ktp'=>'array',
            'terdaftar_pada' => 'timestamp',
            'terverifikasi_pada' => 'timestamp',
        ];
    }

    public function permohonans(): HasMany
    {
        return $this->hasMany(Permohonan::class);
    }

    public function rt(): BelongsTo
    {
        return $this->belongsTo(Rt::class);
    }
}
