<?php

use App\Http\Controllers\ContactUsController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


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
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', fn () => view('dashboard'))->name('dashboard');
});



/**
 * POST ROUTES
 */
Route::middleware(['throttle:form-submit'])->group(function () {
    Route::post('/contact-us', [ContactUsController::class, 'storeContactUsForm'])->name('storeContactUsForm');
});



require __DIR__ . '/auth.php';
