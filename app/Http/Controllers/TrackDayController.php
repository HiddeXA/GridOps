<?php

namespace App\Http\Controllers;

use App\Models\TrackDay;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $trackday = Auth::user()->trackDays->where('id', $trackDayId)->first();

        $trackday->load('sessions');
        $trackday->load('sessions.rounds');

        return Inertia::render('TrackDay')->with('trackDay', $trackday->toArray());
    }

    public function update(Request $request, $trackDayId){
        $data = $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
            'location' => 'required',
            'vehicle' => 'required',
            'notes' => 'nullable',
            'facilities' => 'nullable',
        ]);

        $trackDay = auth()->user()->trackDays()->where('id', $trackDayId)->first();

        $trackDay->update($data);


    }

}
