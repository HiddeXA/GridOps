<?php

namespace App\Http\Controllers;

use App\Models\TrackDay;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TrackDayController extends Controller
{
    public function index()
    {
        $trackDays = TrackDay::orderBy('start_date')->get();

        return Inertia::render('Dashboard')->with('trackDays', $trackDays->toArray());
    }

    public function show($trackDayId)
    {
        $trackday = TrackDay::where('id', $trackDayId)->first();

        return Inertia::render('TrackDay')->with('trackday', $trackday->toArray());
    }
}
