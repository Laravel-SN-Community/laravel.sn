<?php

use App\Enums\ArticleStatus;
use App\Filament\Resources\Articles\Pages\CreateArticle;
use App\Filament\Resources\Articles\Pages\EditArticle;
use App\Models\Article;
use App\Models\Technology;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

test('can render create article page', function () {
    Livewire::test(CreateArticle::class)
        ->assertSuccessful();
});

test('can create an article', function () {
    $articleData = [
        'title' => 'Test Article',
        'slug' => 'test-article',
        'content' => '# Test Content

This is a test article with some content.',
        'status' => ArticleStatus::Draft,
    ];

    Livewire::test(CreateArticle::class)
        ->fillForm($articleData)
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Article::class, [
        'title' => 'Test Article',
        'slug' => 'test-article',
        'status' => ArticleStatus::Draft,
    ]);
});

test('can create an article with technologies', function () {
    $technology1 = Technology::create(['name' => 'Laravel', 'slug' => 'laravel']);
    $technology2 = Technology::create(['name' => 'PHP', 'slug' => 'php']);

    $articleData = [
        'title' => 'Laravel Tutorial',
        'slug' => 'laravel-tutorial',
        'content' => '# Laravel Tutorial

Learn Laravel basics.',
        'status' => ArticleStatus::Published,
        'technologies' => [$technology1->id, $technology2->id],
    ];

    Livewire::test(CreateArticle::class)
        ->fillForm($articleData)
        ->call('create')
        ->assertHasNoFormErrors();

    $article = Article::where('slug', 'laravel-tutorial')->first();

    expect($article)->not->toBeNull();
    expect($article->technologies)->toHaveCount(2);
    expect($article->technologies->pluck('name')->toArray())->toContain('Laravel', 'PHP');
});

test('can validate article creation', function () {
    Livewire::test(CreateArticle::class)
        ->fillForm([
            'title' => '',
            'slug' => '',
            'content' => '',
        ])
        ->call('create')
        ->assertHasFormErrors([
            'title' => 'required',
            'slug' => 'required',
            'content' => 'required',
        ]);
});

test('slug must be unique when creating article', function () {
    Article::factory()->create(['slug' => 'existing-slug']);

    Livewire::test(CreateArticle::class)
        ->fillForm([
            'title' => 'Test Article',
            'slug' => 'existing-slug',
            'content' => 'Test content',
            'status' => ArticleStatus::Draft,
        ])
        ->call('create')
        ->assertHasFormErrors(['slug']);
});

test('can edit an article', function () {
    $article = Article::factory()->create([
        'title' => 'Original Title',
        'slug' => 'original-slug',
    ]);

    Livewire::test(EditArticle::class, ['record' => $article->getRouteKey()])
        ->fillForm([
            'title' => 'Updated Title',
            'slug' => 'updated-slug',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($article->fresh())
        ->title->toBe('Updated Title')
        ->slug->toBe('updated-slug');
});

test('can attach technologies to existing article', function () {
    $article = Article::factory()->create();
    $technology1 = Technology::create(['name' => 'Vue.js', 'slug' => 'vuejs']);
    $technology2 = Technology::create(['name' => 'React', 'slug' => 'react']);

    Livewire::test(EditArticle::class, ['record' => $article->getRouteKey()])
        ->fillForm([
            'technologies' => [$technology1->id, $technology2->id],
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($article->fresh()->technologies)->toHaveCount(2);
    expect($article->technologies->pluck('name')->toArray())->toContain('Vue.js', 'React');
});

test('can update technologies on article', function () {
    $article = Article::factory()->create();
    $technology1 = Technology::create(['name' => 'JavaScript', 'slug' => 'javascript']);
    $technology2 = Technology::create(['name' => 'TypeScript', 'slug' => 'typescript']);
    $technology3 = Technology::create(['name' => 'Node.js', 'slug' => 'nodejs']);

    $article->technologies()->attach([$technology1->id, $technology2->id]);

    expect($article->fresh()->technologies)->toHaveCount(2);

    Livewire::test(EditArticle::class, ['record' => $article->getRouteKey()])
        ->fillForm([
            'technologies' => [$technology3->id],
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $article->refresh();
    expect($article->technologies)->toHaveCount(1);
    expect($article->technologies->first()->name)->toBe('Node.js');
});

test('can remove all technologies from article', function () {
    $article = Article::factory()->create();
    $technology = Technology::create(['name' => 'Python', 'slug' => 'python']);

    $article->technologies()->attach($technology->id);
    expect($article->fresh()->technologies)->toHaveCount(1);

    Livewire::test(EditArticle::class, ['record' => $article->getRouteKey()])
        ->fillForm([
            'technologies' => [],
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($article->fresh()->technologies)->toHaveCount(0);
});
