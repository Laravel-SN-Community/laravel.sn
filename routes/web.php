<?php

use App\Http\Controllers\SocialiteController;
use App\Livewire\Pages\Articles\Show as ShowArticle;
use App\Livewire\Pages\ArticlesPage;
use App\Livewire\Pages\DashboardPage;
use App\Livewire\Pages\Events\Show as ShowEvent;
use App\Livewire\Pages\EventsPage;
use App\Livewire\Pages\ProjectPage;
use App\Livewire\Pages\Projects\Index as ProjectsIndex;
use App\Livewire\Pages\WelcomePage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\Articles\Index as ArticlesIndex;
use App\Livewire\Pages\Articles\CreateOrEdit as ArticlesCreateOrEdit;

// Route::middleware('guest')->group(function () {

// });

Route::get('/', WelcomePage::class)->name('welcome');
Route::get('/events', EventsPage::class)->name('events');
Route::get('/event/{event}', ShowEvent::class)->name('event.show');
Route::get('/articles', ArticlesPage::class)->name('articles');
Route::get('/article/{article:slug}', ShowArticle::class)->name('article.show');
Route::get('/projects', ProjectPage::class)->name('projects');

Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])
    ->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])
    ->name('socialite.callback');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', DashboardPage::class)->name('dashboard');
    Route::get('/projects/create', ProjectsIndex::class)->name('projects.index');
    Route::get('/my-articles', ArticlesIndex::class)->name('articles.index');
    Route::get('/articles/create', ArticlesCreateOrEdit::class)->name('articles.create');
    Route::get('/articles/{id}/edit', ArticlesCreateOrEdit::class)->name('articles.edit');
});
