<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionRound extends Model
{
    protected $fillable = [
        'session_id',
        'lap_time'
    ];

    protected $casts = [
        'lap_time' => 'datetime:Y-m-d H:i:s.u',
    ];
}
