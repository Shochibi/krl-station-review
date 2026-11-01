<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StationController;
use App\Http\Controllers\ReviewController;


// Homepage
Route::get('/', [StationController::class, 'index'])
    ->name('home');


// Detail stasiun
Route::get('/stations/{station}', [StationController::class, 'show'])
    ->name('stations.show');


// Routes yang membutuhkan autentikasi
Route::middleware('auth')->group(function () {

    // Membuat review atau private note
    Route::post(
        '/stations/{station}/reviews',
        [ReviewController::class, 'store']
    )->name('reviews.store');

    // My Private Notes
    Route::get(
        '/my-notes',
        [ReviewController::class, 'myNotes']
    )->name('reviews.my-notes');

});


// Routes autentikasi dari Breeze
require __DIR__.'/auth.php';