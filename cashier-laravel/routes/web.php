<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Send each authenticated user to the home for their role: members get the
// member portal, staff (manager/cashier) get the POS app.
$roleHome = fn () => auth()->user()?->isMember()
    ? redirect()->route('member.dashboard')
    : redirect()->route('pos');

// Public static onepage for guests; authenticated users go straight to their
// dynamic home (member portal or manager/cashier POS dashboard).
Route::get('/', function () use ($roleHome) {
    return auth()->check() ? $roleHome() : view('public.home');
})->name('home');

Route::middleware('auth')->group(function () use ($roleHome) {
    // Breeze redirects here after login/registration; branch by role.
    Route::get('/dashboard', $roleHome)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Staff-only POS app (manager + cashier).
Route::middleware(['auth', 'role:manager,cashier'])->group(function () {
    Route::get('/pos', [PosController::class, 'index'])->name('pos');

    // Manager creates members (auth account + gym profile) from the POS.
    Route::post('/members', [MemberController::class, 'store'])
        ->middleware('role:manager')
        ->name('members.store');
});

// Member-only portal (separate template, no POS sidebar).
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/member', [MemberController::class, 'dashboard'])->name('member.dashboard');
});

require __DIR__.'/auth.php';
