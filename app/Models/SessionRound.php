<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class SessionRound extends Model
{
    protected $fillable = [
        'session_id',
        'lap_time'
    ];


    public function lapTime() {
        return Attribute::make(
            get: function () {
                return Carbon::createFromTimestampMs($this->lap_time)->format('i:s.v');
            }
        );
    }
}
