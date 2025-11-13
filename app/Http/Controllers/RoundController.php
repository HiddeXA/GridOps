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

        if (preg_match('/^(\d{2}):(\d{2})\.(\d{3})$/', $request->get('lap_time'), $matches)) {
            $minutes = (int)$matches[1];
            $seconds = (int)$matches[2];
            $milliseconds = (int)$matches[3];

            $round->lap_time = ($minutes * 60 * 1000) + ($seconds * 1000) + $milliseconds;
        } else {
            throw new \InvalidArgumentException('Ongeldig tijdformaat. Gebruik mm:ss.xxx');
        }
        
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
