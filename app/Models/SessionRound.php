<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionRound extends Model
{
    protected $fillable = [
        'session_id',
        'lap_time'
    ];
}
