<?php

use App\Livewire\Pages\FeedsPage;
use App\Models\RssSource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('feeds page renders successfully', function () {
    $response = $this->get(route('feeds'));

    $response->assertStatus(200);
});

test('feeds page displays empty state when no sources configured', function () {
    Livewire::test(FeedsPage::class)
        ->assertSuccessful()
        ->assertSee('No feeds available');
});

test('feeds page displays items from active rss sources', function () {
    $source = RssSource::factory()->create([
        'name' => 'Test Source',
        'feed_url' => 'https://example.com/feed.xml',
        'is_active' => true,
    ]);

    Http::fake([
        'example.com/feed.xml' => Http::response(
            <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
    <channel>
        <title>Test Feed</title>
        <item>
            <title>Test Article Title</title>
            <link>https://example.com/article-1</link>
            <description>This is a test article description.</description>
            <pubDate>Mon, 08 Dec 2025 12:00:00 +0000</pubDate>
        </item>
    </channel>
</rss>
XML,
            200
        ),
    ]);

    Livewire::test(FeedsPage::class)
        ->assertSee('Test Source')
        ->assertSee('Test Article Title');
});

test('feeds page does not display items from inactive sources', function () {
    RssSource::factory()->create([
        'name' => 'Inactive Source',
        'feed_url' => 'https://inactive.com/feed.xml',
        'is_active' => false,
    ]);

    Livewire::test(FeedsPage::class)
        ->assertDontSee('Inactive Source');
});

test('can search feed items', function () {
    $source = RssSource::factory()->create([
        'name' => 'Test Source',
        'feed_url' => 'https://example.com/feed.xml',
        'is_active' => true,
    ]);

    Http::fake([
        'example.com/feed.xml' => Http::response(
            <<<'XML'
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
    <channel>
        <title>Test Feed</title>
        <item>
            <title>Laravel Tutorial</title>
            <link>https://example.com/laravel</link>
            <description>Learn Laravel basics.</description>
            <pubDate>Mon, 08 Dec 2025 12:00:00 +0000</pubDate>
        </item>
        <item>
            <title>Vue.js Guide</title>
            <link>https://example.com/vue</link>
            <description>Frontend development with Vue.</description>
            <pubDate>Mon, 08 Dec 2025 11:00:00 +0000</pubDate>
        </item>
    </channel>
</rss>
XML,
            200
        ),
    ]);

    Livewire::test(FeedsPage::class)
        ->set('search', 'Laravel')
        ->assertSee('Laravel Tutorial')
        ->assertDontSee('Vue.js Guide');
});

test('can clear filters', function () {
    Livewire::test(FeedsPage::class)
        ->set('search', 'test')
        ->set('selectedSourceId', 1)
        ->call('clearFilters')
        ->assertSet('search', '')
        ->assertSet('selectedSourceId', null);
});

test('rss feed service parses atom feeds', function () {
    $source = RssSource::factory()->create([
        'name' => 'Atom Source',
        'feed_url' => 'https://atom.example.com/feed',
        'is_active' => true,
    ]);

    Http::fake([
        'atom.example.com/feed' => Http::response(
            <<<'XML'
<?xml version="1.0" encoding="utf-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">
    <title>Atom Feed</title>
    <entry>
        <title>Atom Entry Title</title>
        <link href="https://atom.example.com/entry-1" rel="alternate"/>
        <summary>This is an atom entry summary.</summary>
        <published>2025-12-08T12:00:00Z</published>
    </entry>
</feed>
XML,
            200
        ),
    ]);

    Livewire::test(FeedsPage::class)
        ->assertSee('Atom Entry Title');
});

test('handles feed fetch errors gracefully', function () {
    $source = RssSource::factory()->create([
        'name' => 'Error Source',
        'feed_url' => 'https://error.example.com/feed',
        'is_active' => true,
    ]);

    Http::fake([
        'error.example.com/feed' => Http::response('', 500),
    ]);

    Livewire::test(FeedsPage::class)
        ->assertSuccessful()
        ->assertSee('No feeds available');
});

