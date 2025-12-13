<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotSession extends Model
{
    protected $fillable = [
        'phone',
        'session_state',
        'last_activity'
    ];

    protected $casts = [
        'last_activity' => 'datetime',
    ];
}
