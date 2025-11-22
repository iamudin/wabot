<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Registrasi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sesi_dimulai',
        'sesi_berakir',
        'nomor_whatsapp',
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
            'sesi_dimulai' => 'timestamp',
            'sesi_berakir' => 'timestamp',
        ];
    }

    public function dataRegistrasis(): HasMany
    {
        return $this->hasMany(DataRegistrasi::class);
    }
}
