<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    ContactUsController
};


/**
 * GET ROUTES
 */
/**
 * Guest
 */
Route::get('/', fn () => view('auth/login'));

/**
 * Authorised
 */
Route::middleware(['auth', 'EnsureEmailVerified'])->group(function () {
    Route::get('/home', fn () => view('dashboard'))->name('dashboard');
});



/**
 * POST ROUTES
 */
Route::middleware(['throttle:form-submit'])->group(function () {
    Route::post('/contact-us', [ContactUsController::class, 'storeContactUsForm'])->name('storeContactUsForm');
});



require __DIR__ . '/auth.php';
