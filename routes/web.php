<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Livewire\Pages\WelcomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', WelcomePage::class)->name('welcome');

// GitHub OAuth Routes
Route::get('/auth/github', [SocialiteController::class, 'redirectToGithub'])->name('auth.github');
Route::get('/auth/github/callback', [SocialiteController::class, 'handleGithubCallback'])->name('auth.github.callback');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
