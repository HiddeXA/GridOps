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

Route::get('dashboard', [TrackDayController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
