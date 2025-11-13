<?php

namespace App\Http\Controllers;

use App\Models\TrackDay;
use App\Models\TrackDaySession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SessionController extends Controller
{
    public function create(Request $request)
    {
        $trackDay = TrackDay::findOrFail($request->track_day_id);

        if ($trackDay->user_id !== auth()->id()) {
            abort(403, 'Je hebt geen toestemming om sessies toe te voegen aan deze trackday.');
        }

        $session = $trackDay->sessions()->create([
            'start_time' => $trackDay->start_date,
            'end_time' => (new Carbon($trackDay->start_date))->addMinutes(20),
        ]);

        return Response()->json($session);;
    }

    public function destroy($sessionId)
    {
        $session = TrackDaySession::with('trackDay')->findOrFail($sessionId);

        if ($session->trackDay->user_id !== auth()->id()) {
            abort(403, 'Je hebt geen toestemming om deze sessie te verwijderen.');
        }

        $session->delete();
    }
}
