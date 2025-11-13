<?php

namespace App\Http\Controllers;

use App\Models\SessionRound;
use App\Models\TrackDaySession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoundController extends Controller
{
    public function update($id, Request $request) {

        $round = SessionRound::findOrFail($id);

        if (!Auth::user()->trackDays()
            ->whereHas('sessions.rounds', function($query) use ($id) {
                $query->where('id', $id);
            })->exists()) {
            abort(403, 'Unauthorized action.');
        }

        $round->lap_time = Carbon::createFromFormat("i:s.v", $request->get('lap_time'))->getTimestampMs();
        $round->save();

        return response()->json($round);

    }

    public function destroy($id) {
        if (!Auth::user()->trackDays()
            ->whereHas('sessions.rounds', function($query) use ($id) {
                $query->where('id', $id);
            })->exists()) {
            abort(403, 'Unauthorized action.');
        }

        $round = SessionRound::findOrFail($id);
        $round->delete();
    }

    public function create(Request $request) {
        $request->validate([
            'lap_time' => 'required',
            'session_id' => 'required',
        ]);

        $id = $request->get('session_id');

        if (!Auth::user()->trackDays()
            ->whereHas('sessions', function($query) use ($id) {
                $query->where('id', $id);
            })->exists()) {
            abort(403, 'Unauthorized action.');
        }

        $session = TrackDaySession::findOrFail($id);

        $ms =  Carbon::createFromFormat("i:s.v", $request->get('lap_time'))->getTimestampMs();

        $round = $session->rounds()->create([
            'lap_time' => $ms,
        ]);

        return response()->json($round);
    }
}
