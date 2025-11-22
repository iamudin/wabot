<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layanan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kategori_id',
        'nama_layanan',
        'keterangan',
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
            'kategori_id' => 'integer',
            'status' => 'boolean',
        ];
    }

    public function permohonans(): HasMany
    {
        return $this->hasMany(Permohonan::class);
    }

    public function syaratLayanans(): HasMany
    {
        return $this->hasMany(SyaratLayanan::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }
}
