<?php

declare(strict_types=1);

use App\Models\Article;
use App\Models\Tag;
use Database\Seeders\RolesAndPermissionsSeeder;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(fn () => $this->seed(RolesAndPermissionsSeeder::class));

// published_at is a date chosen by the author, so it sits at midnight, while
// content_updated_at is a real instant. The "Mis à jour" label has to tell a
// genuine post-publication edit apart from an article that simply happened to
// be written some hours after the midnight it was published at.

test('an article written and published the same day, never edited, is not revised', function (): void {
    $article = Article::factory()->create([
        'created_at' => today()->setTime(14, 57),
        'published_at' => today(),
        'content_updated_at' => today()->setTime(14, 57),
    ]);

    expect($article->was_revised)->toBeFalse();
});

test('an article edited later the same day it was published is revised', function (): void {
    $article = Article::factory()->create([
        'created_at' => today()->setTime(14, 57),
        'published_at' => today(),
        'content_updated_at' => today()->setTime(15, 30),
    ]);

    expect($article->was_revised)->toBeTrue();
});

test('an article edited days after publication is revised', function (): void {
    $article = Article::factory()->create([
        'created_at' => today()->subWeeks(2),
        'published_at' => today()->subWeek(),
        'content_updated_at' => today(),
    ]);

    expect($article->was_revised)->toBeTrue();
});

test('a draft edited before it went live is not revised', function (): void {
    $article = Article::factory()->create([
        'created_at' => today()->subDays(3),
        'published_at' => today(),
        'content_updated_at' => today()->subDay(),
    ]);

    expect($article->was_revised)->toBeFalse();
});

test('an article without a publication date is never revised', function (): void {
    $article = Article::factory()->draft()->create([
        'published_at' => null,
        'content_updated_at' => now(),
    ]);

    expect($article->was_revised)->toBeFalse();
});

test('an article without a content timestamp is never revised', function (): void {
    $article = Article::factory()->create([
        'published_at' => today(),
        'content_updated_at' => null,
    ]);

    expect($article->was_revised)->toBeFalse();
});

test('the article page reports an untouched article as not revised', function (): void {
    $article = Article::factory()->create([
        'created_at' => today()->setTime(14, 57),
        'published_at' => today(),
        'content_updated_at' => today()->setTime(14, 57),
    ]);

    $this->get(route('article', $article))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->component('articles/show')
            ->where('article.was_revised', false)
        );
});

test('the article page reports a genuine edit as revised', function (): void {
    $article = Article::factory()->create([
        'created_at' => today()->subWeeks(2),
        'published_at' => today()->subWeek(),
        'content_updated_at' => today(),
    ]);

    $this->get(route('article', $article))
        ->assertOk()
        ->assertInertia(fn (Assert $page): Assert => $page
            ->where('article.was_revised', true)
        );
});

test('editing a published article through the app flags it as revised', function (): void {
    $article = Article::factory()->create([
        'created_at' => today()->subWeek(),
        'published_at' => today()->subWeek(),
        'content_updated_at' => today()->subWeek(),
    ]);
    $tag = Tag::factory()->create();

    expect($article->was_revised)->toBeFalse();

    $this->actingAs($article->author)
        ->patch(route('articles.update', $article), [
            'title' => $article->title,
            'body' => $article->body.' Un paragraphe ajouté après publication.',
            'locale' => $article->locale,
            'tags' => [$tag->id],
        ])
        ->assertRedirect();

    expect($article->fresh()->was_revised)->toBeTrue();
});
