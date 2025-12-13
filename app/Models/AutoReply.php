<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoReply extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'key', 'value', 'level', 'parent_id',
        'action',
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
        ];
    }

    public function parent(){
        return $this->belongsTo(AutoReply::class, 'parent_id');
    }

    public function childs()
    {
        return $this->hasMany(AutoReply::class, 'parent_id');
    }
}
