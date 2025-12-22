<?php

use App\Filament\Resources\RssSources\Pages\CreateRssSource;
use App\Filament\Resources\RssSources\Pages\EditRssSource;
use App\Filament\Resources\RssSources\Pages\ListRssSources;
use App\Models\RssSource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

test('can render rss sources list page', function () {
    Livewire::test(ListRssSources::class)
        ->assertSuccessful();
});

test('can render create rss source page', function () {
    Livewire::test(CreateRssSource::class)
        ->assertSuccessful();
});

test('can create an rss source', function () {
    $sourceData = [
        'name' => 'Laravel News',
        'feed_url' => 'https://laravel-news.com/feed',
        'description' => 'The official Laravel news source',
        'is_active' => true,
    ];

    Livewire::test(CreateRssSource::class)
        ->fillForm($sourceData)
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(RssSource::class, [
        'name' => 'Laravel News',
        'feed_url' => 'https://laravel-news.com/feed',
        'is_active' => true,
    ]);
});

test('can validate rss source creation', function () {
    Livewire::test(CreateRssSource::class)
        ->fillForm([
            'name' => '',
            'feed_url' => '',
        ])
        ->call('create')
        ->assertHasFormErrors([
            'name' => 'required',
            'feed_url' => 'required',
        ]);
});

test('feed url must be a valid url', function () {
    Livewire::test(CreateRssSource::class)
        ->fillForm([
            'name' => 'Test Source',
            'feed_url' => 'not-a-valid-url',
        ])
        ->call('create')
        ->assertHasFormErrors(['feed_url']);
});

test('feed url must be unique', function () {
    RssSource::factory()->create(['feed_url' => 'https://example.com/feed']);

    Livewire::test(CreateRssSource::class)
        ->fillForm([
            'name' => 'Test Source',
            'feed_url' => 'https://example.com/feed',
        ])
        ->call('create')
        ->assertHasFormErrors(['feed_url']);
});

test('can edit an rss source', function () {
    $source = RssSource::factory()->create([
        'name' => 'Original Name',
        'feed_url' => 'https://original.com/feed',
    ]);

    Livewire::test(EditRssSource::class, ['record' => $source->getRouteKey()])
        ->fillForm([
            'name' => 'Updated Name',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($source->fresh())
        ->name->toBe('Updated Name');
});

test('can toggle active status', function () {
    $source = RssSource::factory()->create([
        'is_active' => true,
    ]);

    Livewire::test(EditRssSource::class, ['record' => $source->getRouteKey()])
        ->fillForm([
            'is_active' => false,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($source->fresh())
        ->is_active->toBeFalse();
});

test('list page shows rss sources', function () {
    $sources = RssSource::factory()->count(3)->create();

    Livewire::test(ListRssSources::class)
        ->assertCanSeeTableRecords($sources);
});

test('can search rss sources by name', function () {
    $laravelNews = RssSource::factory()->create(['name' => 'Laravel News']);
    $phpNews = RssSource::factory()->create(['name' => 'PHP Weekly']);

    Livewire::test(ListRssSources::class)
        ->searchTable('Laravel')
        ->assertCanSeeTableRecords([$laravelNews])
        ->assertCanNotSeeTableRecords([$phpNews]);
});

test('can filter by active status', function () {
    $active = RssSource::factory()->create(['is_active' => true]);
    $inactive = RssSource::factory()->inactive()->create();

    Livewire::test(ListRssSources::class)
        ->filterTable('is_active', true)
        ->assertCanSeeTableRecords([$active])
        ->assertCanNotSeeTableRecords([$inactive]);
});
