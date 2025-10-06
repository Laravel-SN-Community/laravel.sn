<?php

use App\Enums\ArticleStatus;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('displays the blog page', function () {
    $response = $this->get('/blog');

    $response->assertStatus(200);
    $response->assertSee('Blog Laravel Sénégal');
});

it('displays published articles on blog page', function () {
    $publishedArticle = Article::factory()->create([
        'title' => 'Test Article',
        'status' => ArticleStatus::Published,
        'published_at' => now(),
    ]);

    $draftArticle = Article::factory()->create([
        'title' => 'Draft Article',
        'status' => ArticleStatus::Draft,
        'published_at' => now(),
    ]);

    $response = $this->get('/blog');

    $response->assertStatus(200);
    $response->assertSee('Test Article');
    $response->assertDontSee('Draft Article');
});

it('can search articles on blog page', function () {
    $article1 = Article::factory()->create([
        'title' => 'Unique Search Term Article',
        'content' => 'This article contains a unique search term that should be found',
        'status' => ArticleStatus::Published,
        'published_at' => now(),
    ]);

    $article2 = Article::factory()->create([
        'title' => 'Another Article',
        'content' => 'This article should not be found in search results',
        'status' => ArticleStatus::Published,
        'published_at' => now(),
    ]);

    // First, check that both articles are visible without search
    $response = $this->get('/blog');
    $response->assertStatus(200);
    $response->assertSee('Unique Search Term Article');
    $response->assertSee('Another Article');

    // Then test the search
    $response = $this->get('/blog?search=Unique Search Term');
    $response->assertStatus(200);
    $response->assertSee('Unique Search Term Article');
    $response->assertDontSee('Another Article');
});

it('displays individual article page', function () {
    $article = Article::factory()->create([
        'title' => 'Test Article',
        'slug' => 'test-article-' . uniqid(),
        'content' => '<p>This is the article content</p>',
        'status' => ArticleStatus::Published,
        'published_at' => now(),
    ]);

    $response = $this->get("/article/{$article->slug}");

    $response->assertStatus(200);
    $response->assertSee('Test Article');
    $response->assertSee('This is the article content');
});

it('returns 404 for draft articles', function () {
    $article = Article::factory()->create([
        'title' => 'Draft Article',
        'slug' => 'draft-article-' . uniqid(),
        'status' => ArticleStatus::Draft,
        'published_at' => now(),
    ]);

    $response = $this->get("/article/{$article->slug}");

    $response->assertStatus(404);
});

it('returns 404 for non-existent articles', function () {
    $response = $this->get('/article/non-existent-article');

    $response->assertStatus(404);
});
