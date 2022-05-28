<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    AdminController
};

Route::prefix('admin')
    ->middleware(['auth', 'EnsureCorrectAgenda:3'])
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin');

        //Uploaders
        Route::prefix('/upload')->group(function () {
            Route::post('/users', [AdminController::class, 'upload_users'])->name('upload_users');
        });
    });
