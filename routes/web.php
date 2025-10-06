<?php

use App\Livewire\EventsPage;
use App\Livewire\Pages\Articles\Show as ShowArticle;
use App\Livewire\Pages\ArticlesPage;
use App\Livewire\Pages\WelcomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', WelcomePage::class)->name('welcome');
Route::get('/events', EventsPage::class)->name('events');
Route::get('/articles', ArticlesPage::class)->name('articles');
Route::get('/article/{article:slug}', ShowArticle::class)->name('article.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
