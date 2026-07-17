<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
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

// Static public pages: each home section split into its own visitor page.
Route::view('/prices', 'public.prices')->name('public.prices');
Route::view('/about', 'public.about')->name('public.about');
Route::view('/coaches', 'public.coaches')->name('public.coaches');
Route::view('/gallery', 'public.gallery')->name('public.gallery');
Route::view('/contact', 'public.contact')->name('public.contact');

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

    // Manager or cashier creates members (auth account + gym profile) from the POS.
    Route::post('/members', [MemberController::class, 'store'])->name('members.store');

    // Manager or cashier verify a pending registrant (bound by member_code,
    // which is the identifier the POS frontend holds).
    Route::patch('/members/{member:member_code}/verify', [MemberController::class, 'verify'])
        ->name('members.verify');

    // Staff record a bank-transfer proof / intended package for a member.
    Route::post('/members/{member:member_code}/payment', [MemberController::class, 'uploadPayment'])
        ->name('members.payment');

    // Move a member to Trash (soft delete) and restore them.
    Route::delete('/members/{member:member_code}', [MemberController::class, 'destroy'])
        ->name('members.destroy');
    Route::post('/members/{member}/restore', [MemberController::class, 'restore'])
        ->name('members.restore');
});

// Catalog management (items + categories) for every POS unit — manager + cashier.
Route::middleware(['auth', 'role:manager,cashier'])->group(function () {
    Route::post('/units/{unit}/products', [ProductController::class, 'store'])
        ->whereIn('unit', ['gym', 'store', 'kitchen'])
        ->name('products.store');
    Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::delete('/products/{id}/force', [ProductController::class, 'forceDelete'])->name('products.forceDelete');

    Route::post('/units/{unit}/categories', [CategoryController::class, 'store'])
        ->whereIn('unit', ['gym', 'store', 'kitchen'])
        ->name('categories.store');
    Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

// Member-only portal (separate template, no POS sidebar).
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/member', [MemberController::class, 'dashboard'])->name('member.dashboard');

    // Member submits a bank-transfer proof for a chosen package.
    Route::post('/member/payment', [MemberController::class, 'submitPayment'])->name('member.payment');
});

require __DIR__.'/auth.php';
