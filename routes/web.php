<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    ContactUsController,
    DiaryEntryController,
    MemberController,
    UserController,
    MessageController
};

/**
 * Guest
 */
Route::get('/', fn () => view('auth/login'));

/**
 * Authorised
 */
Route::middleware(['auth', 'EnsureEmailVerified'])->group(function () {
    Route::get('/home', fn () => view('dashboard'))->name('dashboard');
    Route::get('/diary', [DiaryEntryController::class, 'index'])->name('diary');
    Route::get('/nutrition', fn () => view('dashboard'))->name('nutrition');
    Route::get('/members', [MemberController::class, 'index'])->name('members');
    Route::get('/leaderboard', fn () => view('dashboard'))->name('leaderboard');
    Route::get('/inbox', [MessageController::class, 'index'])->name('inbox');
    Route::get('/settings', fn () => view('dashboard'))->name('settings');

    //JSON data
    Route::get('/messages/received', [MessageController::class, 'receivedMessagesJSON'])->name('messages_received');
    Route::get('/messages/sent', [MessageController::class, 'sentMessagesJSON'])->name('messages_sent');

    Route::prefix('/api')->group(function () {
        Route::get('/user/json', [UserController::class, 'getUserJSON'])->name('user_json');
        Route::post('/user/unfollow', [MemberController::class, 'unfollowUser'])->name('unfollow_user');
        Route::post('/user/follow', [MemberController::class, 'followUser'])->name('follow_user');
        Route::delete('/message/inbox/delete', [MessageController::class, 'deleteMessageInbox'])->name('delete_message_inbox');
        Route::delete('/message/outbox/delete', [MessageController::class, 'deleteMessageOutbox'])->name('delete_message_outbox');
        Route::post('/message/confirm/read', [MessageController::class, 'setMessageRead'])->name('set_message_read');
        Route::post('/message/confirm/outbox/read', [MessageController::class, 'setOutboxMessageRead'])->name('set_outbox_message_read');
        Route::post('/message/reply', [MessageController::class, 'storeMessageReply'])->name('message_reply');
        Route::get('/users/search', [MemberController::class, 'simpleSearchUsers'])->name('users_search');

        Route::middleware(['throttle:form-submit'])->group(function () {
            Route::post('/user/message', [MessageController::class, 'storeMessage'])->name('message_user');
        });
    });

    Route::middleware(['throttle:form-submit'])->group(function () {
        Route::post('/contact-us', [ContactUsController::class, 'storeContactUsForm'])->name('storeContactUsForm');
    });
});




require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
