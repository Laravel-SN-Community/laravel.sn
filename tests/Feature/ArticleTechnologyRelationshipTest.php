<?php

use App\Models\Article;
use App\Models\Technology;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can attach technologies to an article', function () {
    $article = Article::factory()->create();

    $technology1 = Technology::create(['name' => 'Laravel', 'slug' => 'laravel']);
    $technology2 = Technology::create(['name' => 'PHP', 'slug' => 'php']);

    $article->technologies()->attach([$technology1->id, $technology2->id]);

    expect($article->technologies)->toHaveCount(2);
    expect($article->technologies->pluck('name')->toArray())->toContain('Laravel', 'PHP');
});

test('can retrieve articles from a technology', function () {
    $technology = Technology::create(['name' => 'Vue.js', 'slug' => 'vuejs']);

    $article1 = Article::factory()->create(['title' => 'Article 1']);
    $article2 = Article::factory()->create(['title' => 'Article 2']);

    $technology->articles()->attach([$article1->id, $article2->id]);

    expect($technology->articles)->toHaveCount(2);
    expect($technology->articles->pluck('title')->toArray())->toContain('Article 1', 'Article 2');
});

test('can detach technologies from an article', function () {
    $article = Article::factory()->create();

    $technology = Technology::create(['name' => 'React', 'slug' => 'react']);

    $article->technologies()->attach($technology->id);
    expect($article->technologies)->toHaveCount(1);

    $article->technologies()->detach($technology->id);
    expect($article->fresh()->technologies)->toHaveCount(0);
});

test('can sync technologies to an article', function () {
    $article = Article::factory()->create();

    $technology1 = Technology::create(['name' => 'JavaScript', 'slug' => 'javascript']);
    $technology2 = Technology::create(['name' => 'TypeScript', 'slug' => 'typescript']);
    $technology3 = Technology::create(['name' => 'Node.js', 'slug' => 'nodejs']);

    $article->technologies()->sync([$technology1->id, $technology2->id]);
    expect($article->technologies)->toHaveCount(2);

    $article->technologies()->sync([$technology3->id]);
    $article->refresh();
    expect($article->technologies)->toHaveCount(1);
    expect($article->technologies->first()->name)->toBe('Node.js');
});

test('deleting an article cascades to pivot table', function () {
    $article = Article::factory()->create();

    $technology = Technology::create(['name' => 'Python', 'slug' => 'python']);

    $article->technologies()->attach($technology->id);

    expect($article->technologies)->toHaveCount(1);

    $article->delete();

    expect($technology->fresh()->articles)->toHaveCount(0);
});

test('deleting a technology cascades to pivot table', function () {
    $article = Article::factory()->create();

    $technology = Technology::create(['name' => 'Ruby', 'slug' => 'ruby']);

    $article->technologies()->attach($technology->id);

    expect($article->technologies)->toHaveCount(1);

    $technology->delete();

    expect($article->fresh()->technologies)->toHaveCount(0);
});
