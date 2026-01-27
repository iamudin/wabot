<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotSession extends Model
{
    protected $fillable = [
        'phone',
        'state',
        'payload',
        'current_parent_id',
        'last_activity'
    ];

    protected $casts = [
        'last_activity' => 'datetime',
    ];
}
