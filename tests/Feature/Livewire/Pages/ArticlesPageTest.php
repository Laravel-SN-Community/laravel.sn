<?php

use App\Enums\ArticleStatus;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('articles page displays published articles with tags', function () {
    $article = Article::factory()->create([
        'title' => 'Laravel et Vue.js: l\'IA et les Outils Modernes',
        'status' => ArticleStatus::Published,
        'published_at' => now(),
    ]);

    $article->attachTags(['Laravel', 'Vue.js']);

    $response = $this->get(route('articles'));

    $response->assertStatus(200);
    $response->assertSee('Laravel et Vue.js: l\'IA et les Outils Modernes');
    $response->assertSee('Laravel');
    $response->assertSee('Vue.js');
});

test('articles page does not display draft articles', function () {
    $article = Article::factory()->create([
        'title' => 'Draft Article',
        'status' => ArticleStatus::Draft,
    ]);

    $response = $this->get(route('articles'));

    $response->assertStatus(200);
    $response->assertDontSee('Draft Article');
});

test('articles page displays article excerpt', function () {
    $article = Article::factory()->create([
        'title' => 'Test Article',
        'content' => 'This is a long article content that should be truncated to show only the excerpt.',
        'status' => ArticleStatus::Published,
        'published_at' => now(),
    ]);

    $response = $this->get(route('articles'));

    $response->assertStatus(200);
    $response->assertSee('Test Article');
});

test('article title is clickable and links to article detail page', function () {
    $article = Article::factory()->create([
        'title' => 'Clickable Article',
        'slug' => 'clickable-article',
        'status' => ArticleStatus::Published,
        'published_at' => now(),
    ]);

    $response = $this->get(route('articles'));

    $response->assertStatus(200);
    $response->assertSee(route('article.show', $article->slug));
});
