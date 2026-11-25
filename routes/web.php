<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;

// Homepage
Route::get('/', [StationController::class, 'index'])
    ->name('home');

// Detail stasiun
Route::get('/stations/{station}', [StationController::class, 'show'])
    ->name('stations.show');

// Routes yang membutuhkan autentikasi
Route::middleware('auth')->group(function () {
    // Breeze dashboard & profile
    Route::get('/dashboard', function () {
        $user = auth()->user();

        $publicReviewsCount = $user->reviews()->public()->count();
        $privateNotesCount = $user->privateNotes()->count();
        $recentReviews = $user->reviews()
            ->with('station')
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'publicReviewsCount',
            'privateNotesCount',
            'recentReviews'
        ));
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Membuat review atau private note
    Route::post(
        '/stations/{station}/reviews',
        [ReviewController::class, 'store']
    )->name('reviews.store');

    // Edit review atau private note
    Route::get(
        '/reviews/{review}/edit',
        [ReviewController::class, 'edit']
    )->name('reviews.edit');

    Route::match(
        ['put', 'patch'],
        '/reviews/{review}',
        [ReviewController::class, 'update']
    )->name('reviews.update');

    // Hapus review atau private note (Author atau Admin)
    Route::delete(
        '/reviews/{review}',
        [ReviewController::class, 'destroy']
    )->name('reviews.destroy');

    // My Private Notes (Buku Saku Komuter)
    Route::get(
        '/my-notes',
        [ReviewController::class, 'myNotes']
    )->name('reviews.my-notes');
});


// Routes autentikasi dari Breeze
require __DIR__.'/auth.php';