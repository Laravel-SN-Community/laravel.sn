<?php

use App\Models\RssSource;
use Database\Seeders\RssSourceSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('rss source seeder seeds freek dev feed', function () {
    $this->seed(RssSourceSeeder::class);

    $this->assertDatabaseHas(RssSource::class, [
        'feed_url' => 'https://freek.dev/feed',
        'name' => 'freek.dev',
        'is_active' => true,
    ]);
});
