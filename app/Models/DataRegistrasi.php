<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataRegistrasi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'registrasi_id',
        'kata_kunci',
        'pertanyaan',
        'jawaban',
        'urutan',
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
            'registrasi_id' => 'integer',
            'urutan' => 'integer',
        ];
    }

    public function registrasi(): BelongsTo
    {
        return $this->belongsTo(Registrasi::class);
    }
}
