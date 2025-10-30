<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class TrackDaySession extends Model
{
    protected $fillable = [
        'track_day_id',
        'start_time',
        'end_time',
        ];

    protected $appends = [
        'personal_best_time',
        ];



    protected function personalBestTime() : Attribute
    {
        return Attribute::make(
            get: function () {
                $time = new Carbon($this->rounds()->min('lap_time'));
                return $time->format('i:s.v');
            }
        );
    }

    public function rounds()
    {
        return $this->hasMany(SessionRound::class);
    }

}
