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

        $round->lap_time = "00:".$request->get('lap_time');
        $round->save();
        dd( $round);

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

        $round = $session->rounds()->create([
            'lap_time' => $request->get('lap_time'),
        ]);

        return response()->json($round);
    }
}
