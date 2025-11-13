<?php

use App\Http\Controllers\RoundController;
use App\Http\Controllers\SessionController;
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

Route::group([
    'middleware' => 'auth',
    'prefix' => 'api',
], function () {
    Route::delete('session/delete/{id}', [SessionController::class, 'destroy'])->name('session.delete');
    Route::post('session/create', [SessionController::class, 'create'])->name('session.create');
    Route::post('session/update', [SessionController::class, 'update'])->name('session.update');

    Route::delete('round/delete/{id}', [RoundController::class, 'destroy'])->name('round.delete');
    Route::post('round/create', [RoundController::class, 'create'])->name('round.create');
    Route::put('round/update/{id}', [RoundController::class, 'update'])->name('round.update');

    Route::post('track-day/update/{id}', [TrackDayController::class, 'update'])->name('track-day.update');
});

require __DIR__.'/settings.php';
