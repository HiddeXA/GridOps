<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function Laravel\Prompts\table;

class TrackDaySeeder extends Seeder
{
    /**
     * Makes a user with trackDays.
     */
    public function run(): void
    {
        $userId = DB::table('users')->insertGetId([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ]);

        for ($i = 0; $i < 100; $i++) {
            $trackDayDay = Carbon::now()->addDays(rand(30, 365));
            $trackDayId = DB::table('track_days')->insertGetId([
                'user_id' => $userId,
                'start_date' => $trackDayDay->toDateString(),
                'end_date' => $trackDayDay->addHours(rand(8, 48))->toDateString(),
                'location' => Str::random(10),
                'vehicle' => Str::random(10),
            ]);

            for ($j = 0; $j < rand(3, 6); $j++) {
                $sessionId = DB::table('track_day_sessions')->insertGetId([
                    'track_day_id' => $trackDayId,
                    'start_time' => now(),
                    'end_time' => now()->addMinutes(rand(10, 120)),
                ]);

                for ($k = 0; $k < rand(5, 15); $k++) {
                    DB::table('session_rounds')->insert([
                        'track_day_session_id' => $sessionId,
                        'lap_time' => (new Carbon(rand(60000, 120000)/1000))->getTimestampMs(),
                    ]);
                }
            }
        }


    }
}
