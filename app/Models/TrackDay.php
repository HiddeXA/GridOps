<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class TrackDay extends Model
{

    protected $fillable = [
        'date',
        'location',
        'vehicle',
        'start_date',
        'end_date',
        'notes',
        'facilities'
    ];

    protected $appends = [
        'personal_best_time',
    ];

    protected function personalBestTime() : Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->sessions->min('personal_best_time');
            }
        );
    }

    public function sessions()
    {
        return $this->hasMany(TrackDaySession::class);
    }


}
