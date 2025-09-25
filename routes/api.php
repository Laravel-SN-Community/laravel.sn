<?php

use App\Http\Controllers\NewsletterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('newsletter')->name('newsletter.')->group(function () {
    Route::post('subscribe', [NewsletterController::class, 'subscribe'])->name('subscribe');
    Route::post('unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('unsubscribe');
    Route::get('status', [NewsletterController::class, 'status'])->name('status');
});
