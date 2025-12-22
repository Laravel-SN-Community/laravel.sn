<?php

namespace Database\Seeders;

use App\Models\RssSource;
use Illuminate\Database\Seeder;

class RssSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RssSource::updateOrCreate(
            [
                'feed_url' => 'https://freek.dev/feed',
            ],
            [
                'name' => 'freek.dev',
                'description' => 'All blogposts on freek.dev',
                'is_active' => true,
            ],
        );
    }
}
