<?php

declare(strict_types=1);

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditorImageController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Forum\ChannelController;
use App\Http\Controllers\Forum\ReactionController;
use App\Http\Controllers\Forum\ReplyController;
use App\Http\Controllers\Forum\ThreadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Routing\RedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::middleware('guest')->group(function (): void {
    Route::get('/auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])
        ->whereIn('provider', ['github', 'google'])
        ->name('social.redirect');
    Route::get('/auth/{provider}/callback', [SocialLoginController::class, 'callback'])
        ->whereIn('provider', ['github', 'google'])
        ->name('social.callback');
});

Route::get('/search', SearchController::class)->name('search');

Route::get('/articles', [ArticleController::class, 'index'])->name('articles');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('article');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

Route::prefix('forum')->name('forum.')->group(function (): void {
    Route::get('/', [ChannelController::class, 'index'])->name('index');
    Route::get('/channels', [ChannelController::class, 'channels'])->name('channels.index');
    Route::get('/channels/{channel:slug}', [ChannelController::class, 'show'])->name('channels.show');
    // GET-only on purpose: Route::redirect() answers every HTTP method and,
    // with cached routes, would shadow the POST threads.store route below.
    Route::get('/threads', RedirectController::class)
        ->defaults('destination', '/forum')
        ->defaults('status', 302)
        ->name('threads.index');
    Route::get('/threads/{thread:slug}', [ThreadController::class, 'show'])->name('threads.show');

    Route::middleware('auth')->group(function (): void {
        Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');

        Route::post('/threads/{thread:slug}/replies', [ReplyController::class, 'store'])->name('replies.store');
        Route::patch('/replies/{reply}', [ReplyController::class, 'update'])->name('replies.update');
        Route::delete('/replies/{reply}', [ReplyController::class, 'destroy'])->name('replies.destroy');

        Route::post('/threads/{thread:slug}/solution/{reply}', [ThreadController::class, 'markSolution'])->name('threads.solution');
        Route::delete('/threads/{thread:slug}/solution', [ThreadController::class, 'revokeSolution'])->name('threads.solution.revoke');
        Route::post('/threads/{thread:slug}/subscribe', [ThreadController::class, 'subscribe'])->name('threads.subscribe');
        Route::delete('/threads/{thread:slug}/subscribe', [ThreadController::class, 'unsubscribe'])->name('threads.unsubscribe');

        Route::post('/threads/{thread:slug}/lock', [ThreadController::class, 'lock'])->name('threads.lock');
        Route::delete('/threads/{thread:slug}/lock', [ThreadController::class, 'unlock'])->name('threads.unlock');

        Route::post('/threads/{thread:slug}/pin', [ThreadController::class, 'pin'])->name('threads.pin');
        Route::delete('/threads/{thread:slug}/pin', [ThreadController::class, 'unpin'])->name('threads.unpin');

        Route::post('/threads/{thread:slug}/reactions', [ReactionController::class, 'toggle'])->name('reactions.toggle');
    });
});

Route::get('/@{username}', [UserController::class, 'show'])->name('profile');

Route::inertia('/ressources', 'ressources/index')->name('ressources');

Route::inertia('/rejoindre', 'rejoindre')->name('rejoindre');
Route::inertia('/rules', 'rules')->name('rules');
Route::inertia('/terms', 'terms')->name('terms');
Route::inertia('/privacy', 'privacy')->name('privacy');

Route::middleware('auth')->group(function (): void {
    Route::post('/editor/images', [EditorImageController::class, 'store'])
        ->middleware('throttle:30,1')
        ->name('editor.images.store');
});

Route::middleware(['auth'])->group(function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/articles', [ArticleController::class, 'dashboardIndex'])->name('dashboard.articles');

    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::patch('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::post('/articles/{article}/submit', [ArticleController::class, 'submit'])->name('articles.submit');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    Route::post('/events/{event}/register', [EventController::class, 'register'])->name('events.register');
    Route::delete('/events/{event}/register', [EventController::class, 'unregister'])->name('events.unregister');
    // TODO: réactiver quand ces fonctionnalités seront implémentées
    // Route::inertia('/dashboard/events', 'dashboard/events')->name('dashboard.events');
    // Route::inertia('/dashboard/notifications', 'dashboard/notifications')->name('dashboard.notifications');

    // Management routes — admin or moderator only
    Route::middleware(['role:admin|moderator'])->prefix('dashboard/manage')->name('manage.')->group(function (): void {
        Route::get('/articles', [ArticleController::class, 'manageIndex'])->name('articles.index');
        Route::post('/articles/{article}/publish', [ArticleController::class, 'publish'])->name('articles.publish');
        Route::post('/articles/{article}/decline', [ArticleController::class, 'decline'])->name('articles.decline');
        Route::delete('/articles/{article}', [ArticleController::class, 'manageDestroy'])->name('articles.destroy');
        Route::get('/events', [EventController::class, 'manageIndex'])->name('events.index');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::patch('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
        Route::get('/users', [UserController::class, 'manageIndex'])->name('users.index');
        Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.role');
        Route::post('/users/{user}/suspend', [UserController::class, 'suspend'])->name('users.suspend');
        Route::delete('/users/{user}/suspend', [UserController::class, 'unsuspend'])->name('users.unsuspend');
        Route::delete('/users/{user}', [UserController::class, 'manageDestroy'])->name('users.destroy');
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    });
});

require __DIR__.'/settings.php';
