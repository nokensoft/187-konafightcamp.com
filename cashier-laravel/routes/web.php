<?php

use App\Http\Controllers\PosController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('pos')
        : redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/pos', [PosController::class, 'index'])->name('pos');

    // Breeze redirects here after login; send users into the POS app.
    Route::get('/dashboard', fn () => redirect()->route('pos'))->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
