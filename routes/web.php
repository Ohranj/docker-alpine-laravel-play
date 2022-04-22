<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    ContactUsController,
    MemberController,
    UserController
};

/**
 * Guest
 */
Route::get('/', fn () => view('auth/login'));

/**
 * Authorised
 */
Route::middleware(['auth', 'EnsureEmailVerified'])->group(function () {
    Route::get('/home', fn() => view('dashboard'))->name('dashboard');
    Route::get('/diary', fn() => view('dashboard'))->name('diary');
    Route::get('/nutrition', fn() => view('dashboard'))->name('nutrition');
    Route::get('/members', [MemberController::class, 'index'])->name('members');
    Route::get('/leaderboard', fn() => view('dashboard'))->name('leaderboard');
    Route::get('/inbox', fn() => view('dashboard'))->name('inbox');
    Route::get('/settings', fn() => view('dashboard'))->name('settings');

    Route::prefix('/api')->group(function() {
        Route::get('/user/json', [UserController::class, 'getUserJSON'])->name('user_json');
        Route::post('/user/unfollow', [MemberController::class, 'unfollowUser'])->name('unfollow_user');
        Route::post('/user/follow', [MemberController::class, 'followUser'])->name('follow_user');
    });

    Route::middleware(['throttle:form-submit'])->group(function () {
        Route::post('/contact-us', [ContactUsController::class, 'storeContactUsForm'])->name('storeContactUsForm');
    });
});




require __DIR__ . '/auth.php';
