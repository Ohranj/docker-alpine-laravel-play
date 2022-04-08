<?php

use App\Http\Controllers\ContactUsController;
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
Route::get('/', fn () => view('auth/login'));
//Create route group for auth middleware at least
Route::get('/home', fn () => view('dashboard'))->middleware(['auth'])->name('dashboard');

/**
 * POST ROUTES
 */
Route::post('/contact-us', [ContactUsController::class, 'storeContactUsForm'])->name('storeContactUsForm');



require __DIR__ . '/auth.php';
