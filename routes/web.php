<?php

use App\Http\Controllers\TrackDayController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Home', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('dashboard', [TrackDayController::class, 'index'])
        ->name('dashboard');
    Route::get('dashboard/track-day/{trackDayId}', [TrackDayController::class, 'show'])
        ->name('dashboard.track-day');
});

require __DIR__.'/settings.php';
