<?php

namespace App\Services;

use App\Models\RssSource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RssFeedService
{
    /**
     * Cache duration in seconds (10 minutes default).
     */
    protected int $cacheDuration = 600;

    /**
     * Get aggregated feed items from all active sources.
     *
     * @return Collection<int, array{
     *     title: string,
     *     link: string,
     *     description: string,
     *     published_at: \Carbon\Carbon|null,
     *     source_name: string,
     *     source_id: int
     * }>
     */
    public function getAggregatedFeeds(int $limit = 50): Collection
    {
        $sources = RssSource::active()->get();
        $allItems = collect();

        foreach ($sources as $source) {
            $items = $this->getFeedItems($source);
            $allItems = $allItems->merge($items);
        }

        return $allItems
            ->sortByDesc('published_at')
            ->take($limit)
            ->values();
    }

    /**
     * Get feed items from a single source.
     *
     * @return Collection<int, array{
     *     title: string,
     *     link: string,
     *     description: string,
     *     published_at: \Carbon\Carbon|null,
     *     source_name: string,
     *     source_id: int
     * }>
     */
    public function getFeedItems(RssSource $source): Collection
    {
        $cacheKey = "rss_feed_{$source->id}";

        return Cache::remember($cacheKey, $this->cacheDuration, function () use ($source) {
            return $this->fetchAndParseFeed($source);
        });
    }

    /**
     * Fetch and parse a feed from a source.
     *
     * @return Collection<int, array{
     *     title: string,
     *     link: string,
     *     description: string,
     *     published_at: \Carbon\Carbon|null,
     *     source_name: string,
     *     source_id: int
     * }>
     */
    protected function fetchAndParseFeed(RssSource $source): Collection
    {
        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'User-Agent' => 'Laravel RSS Reader/1.0',
                ])
                ->get($source->feed_url);

            if (! $response->successful()) {
                Log::warning("Failed to fetch RSS feed: {$source->name}", [
                    'url' => $source->feed_url,
                    'status' => $response->status(),
                ]);

                return collect();
            }

            return $this->parseXml($response->body(), $source);
        } catch (\Exception $e) {
            Log::error("Error fetching RSS feed: {$source->name}", [
                'url' => $source->feed_url,
                'error' => $e->getMessage(),
            ]);

            return collect();
        }
    }

    /**
     * Parse XML content from RSS or Atom feed.
     *
     * @return Collection<int, array{
     *     title: string,
     *     link: string,
     *     description: string,
     *     published_at: \Carbon\Carbon|null,
     *     source_name: string,
     *     source_id: int
     * }>
     */
    protected function parseXml(string $xml, RssSource $source): Collection
    {
        try {
            libxml_use_internal_errors(true);
            $feed = simplexml_load_string($xml);

            if ($feed === false) {
                Log::warning("Failed to parse RSS feed XML: {$source->name}");

                return collect();
            }

            // Detect feed type and parse accordingly
            if (isset($feed->channel->item)) {
                // RSS 2.0 format
                return $this->parseRss($feed, $source);
            } elseif (isset($feed->entry)) {
                // Atom format
                return $this->parseAtom($feed, $source);
            }

            Log::warning("Unknown feed format: {$source->name}");

            return collect();
        } catch (\Exception $e) {
            Log::error("Error parsing feed XML: {$source->name}", [
                'error' => $e->getMessage(),
            ]);

            return collect();
        }
    }

    /**
     * Parse RSS 2.0 format feed.
     *
     * @return Collection<int, array{
     *     title: string,
     *     link: string,
     *     description: string,
     *     published_at: \Carbon\Carbon|null,
     *     source_name: string,
     *     source_id: int
     * }>
     */
    protected function parseRss(\SimpleXMLElement $feed, RssSource $source): Collection
    {
        $items = collect();

        foreach ($feed->channel->item as $item) {
            $items->push([
                'title' => (string) $item->title,
                'link' => (string) $item->link,
                'description' => $this->cleanDescription((string) $item->description),
                'published_at' => $this->parseDate((string) $item->pubDate),
                'source_name' => $source->name,
                'source_id' => $source->id,
            ]);
        }

        return $items;
    }

    /**
     * Parse Atom format feed.
     *
     * @return Collection<int, array{
     *     title: string,
     *     link: string,
     *     description: string,
     *     published_at: \Carbon\Carbon|null,
     *     source_name: string,
     *     source_id: int
     * }>
     */
    protected function parseAtom(\SimpleXMLElement $feed, RssSource $source): Collection
    {
        $items = collect();

        foreach ($feed->entry as $entry) {
            $link = '';
            foreach ($entry->link as $linkEl) {
                if ((string) $linkEl['rel'] === 'alternate' || empty((string) $linkEl['rel'])) {
                    $link = (string) $linkEl['href'];
                    break;
                }
            }

            $items->push([
                'title' => (string) $entry->title,
                'link' => $link,
                'description' => $this->cleanDescription((string) ($entry->summary ?? $entry->content ?? '')),
                'published_at' => $this->parseDate((string) ($entry->published ?? $entry->updated ?? '')),
                'source_name' => $source->name,
                'source_id' => $source->id,
            ]);
        }

        return $items;
    }

    /**
     * Clean HTML from description and limit length.
     */
    protected function cleanDescription(string $description): string
    {
        $text = strip_tags(html_entity_decode($description));
        $text = preg_replace('/\s+/', ' ', $text);

        return \Illuminate\Support\Str::limit(trim($text), 300);
    }

    /**
     * Parse date string to Carbon instance.
     */
    protected function parseDate(string $date): ?\Carbon\Carbon
    {
        if (empty($date)) {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($date);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Clear the cache for a specific source or all sources.
     */
    public function clearCache(?RssSource $source = null): void
    {
        if ($source) {
            Cache::forget("rss_feed_{$source->id}");
        } else {
            $sources = RssSource::all();
            foreach ($sources as $src) {
                Cache::forget("rss_feed_{$src->id}");
            }
        }
    }

    /**
     * Set the cache duration.
     */
    public function setCacheDuration(int $seconds): self
    {
        $this->cacheDuration = $seconds;

        return $this;
    }
}
