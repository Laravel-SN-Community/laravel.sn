<?php

use App\Livewire\Pages\WelcomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', WelcomePage::class)->name('welcome');

Route::prefix('articles')->as('articles.')->group(function (): void {
    Route::get('/', WelcomePage::class)->name('index');
    Route::get('/tags/{tag:slug}', WelcomePage::class)->name('tag');
    Route::get('/{article}', WelcomePage::class)->name('show');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
