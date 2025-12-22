<?php

namespace App\Livewire\Pages;

use App\Services\RssFeedService;
use Livewire\Attributes\Layout;
use Livewire\Component;

class FeedsPage extends Component
{
    public string $search = '';

    public ?int $selectedSourceId = null;

    #[Layout('layouts.guest')]
    public function render(RssFeedService $feedService)
    {
        $feedItems = $feedService->getAggregatedFeeds(100);

        // Filter by search
        if ($this->search) {
            $searchTerm = strtolower($this->search);
            $feedItems = $feedItems->filter(function ($item) use ($searchTerm) {
                return str_contains(strtolower($item['title']), $searchTerm)
                    || str_contains(strtolower($item['description']), $searchTerm)
                    || str_contains(strtolower($item['source_name']), $searchTerm);
            });
        }

        // Filter by source
        if ($this->selectedSourceId) {
            $feedItems = $feedItems->filter(fn ($item) => $item['source_id'] === $this->selectedSourceId);
        }

        // Get unique sources for filter dropdown
        $sources = $feedItems->unique('source_id')->pluck('source_name', 'source_id');

        return view('livewire.pages.feeds-page', [
            'feedItems' => $feedItems->take(50),
            'sources' => $sources,
        ]);
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->selectedSourceId = null;
    }
}
