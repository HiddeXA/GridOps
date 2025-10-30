<?php

namespace App\Http\Controllers;

use App\Models\TrackDay;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TrackDayController extends Controller
{
    public function index()
    {
        $trackDays = TrackDay::orderBy('date')->get();

        return Inertia::render('Dashboard')->with('trackDays', $trackDays->toArray());
    }
}
