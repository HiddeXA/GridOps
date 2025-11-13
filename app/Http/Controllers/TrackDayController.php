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
        $trackDays = TrackDay::orderBy('start_date')->where('user_id', Auth::id())->get();

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
            'start_date' => '',
            'end_date' => '',
            'location' => '',
            'vehicle' => '',
            'notes' => 'nullable',
            'facilities' => 'nullable',
        ]);

        $data['start_date'] = Carbon::parse($data['start_date'])->addHours(2); // temporary fix for timezones
        $data['end_date'] = Carbon::parse($data['end_date'])->addHours(2);

        $trackDay = auth()->user()->trackDays()->where('id', $trackDayId)->first();

        $trackDay->update($data);

    }

    public function create(){
        $trackday = auth()->user()->trackDays()->create([
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addHours(8),
        ]);

        return redirect()->route('dashboard.track-day', $trackday->id);
    }

    public function destroy($trackDayId){
        $trackDay = auth()->user()->trackDays()->where('id', $trackDayId)->first();
        $trackDay->delete();

        return redirect()->route('dashboard');
    }

}
