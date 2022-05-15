<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    AdminController
};

Route::prefix('admin')
    ->middleware(['EnsureCorrectAgenda:3'])
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin');
    });
