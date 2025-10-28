<?php

use App\Http\Controllers\SocialiteController;
use App\Livewire\Pages\Articles\Show as ShowArticle;
use App\Livewire\Pages\ArticlesPage;
use App\Livewire\Pages\DashboardPage;
use App\Livewire\Pages\Events\Show as ShowEvent;
use App\Livewire\Pages\EventsPage;
use App\Livewire\Pages\Projects\Index as ProjectsIndex;
use App\Livewire\Pages\Projects\Create;
use App\Livewire\Pages\Projects\Show as ShowProject;
use App\Livewire\Pages\WelcomePage;
use Illuminate\Support\Facades\Route;

// Readiness endpoint used by the admin warming page. Returns JSON { ready: bool }
Route::get('admin/ready', function () {
    $manifest = public_path('build/manifest.json');

    if (file_exists($manifest)) {
        return response()->json(['ready' => true, 'message' => 'Assets found']);
    }

    return response()->json(['ready' => false, 'message' => 'Assets missing: run npm run build'], 200);
});

// Simple test route to view the warming page directly
Route::get('admin/test-warm', function () {
    return response()->view('admin.warming');
});

Route::get('/', WelcomePage::class)->name('welcome');

Route::get('/events', EventsPage::class)->name('events');
Route::get('/event/{event}', ShowEvent::class)->name('event.show');
Route::get('/articles', ArticlesPage::class)->name('articles');
Route::get('/article/{article:slug}', ShowArticle::class)->name('article.show');
Route::get('/projects', ProjectsIndex::class)->name('projects.index');
Route::get('/projects/{project:slug}', ShowProject::class)->name('projects.show');

// OAuth routes
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

    Route::get('/my-projects', Create::class)->name('my-projects');
});
