<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class TrackDay extends Model
{

    protected $fillable = [
        'location',
        'vehicle',
        'start_date',
        'end_date',
        'notes',
        'facilities'
    ];

    protected $attributes = [
        'facilities' => '',
        'notes' => '',
        'vehicle' => '',
        'location' => '',
    ];

    protected $appends = [
        'personal_best_time',
        'status',
    ];


    protected function personalBestTime() : Attribute
    {
        return Attribute::make(
            get: function () {
                $timeInMs = SessionRound::whereHas('session', function ($query) {
                    $query->where('track_day_id', $this->id);
                });

                if ($timeInMs->count() === 0) { return null;}

                $timeInMs = $timeInMs->orderBy('lap_time')->first()->lap_time;

                return $timeInMs ? Carbon::createFromTimestampMs($timeInMs)->format('i:s.v') : null;
            }
        );
    }

    protected function status() : Attribute
    {
        return Attribute::make(
            get: function () {
                $now = now();
                $startDate = new Carbon($this->start_date);
                $endDate = new Carbon($this->end_date);

                if ($now->isBefore($startDate)) {
                    return 'planned';
                } elseif ($now->isAfter($endDate)) {
                    return 'done';
                } else {
                    return 'onGoing';
                }
            }
        );
    }

    public function sessions()
    {
        return $this->hasMany(TrackDaySession::class);
    }


}
