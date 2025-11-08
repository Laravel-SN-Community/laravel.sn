<?php

namespace App\Livewire\Pages;

use App\Models\ForumCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.guest')]
class ForumCategoryPage extends Component
{
    use WithPagination;

    public ForumCategory $category;

    public string $search = '';

    public string $sortBy = 'latest'; // latest, popular, oldest

    public function mount($slug)
    {
        $this->category = ForumCategory::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $threadsQuery = $this->category->threads()
            ->with(['user', 'category', 'lastPostUser']);

        // Search
        if ($this->search) {
            $threadsQuery->where(function ($query) {
                $query->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('content', 'like', '%'.$this->search.'%');
            });
        }

        // Sorting
        match ($this->sortBy) {
            'popular' => $threadsQuery->orderBy('views_count', 'desc'),
            'oldest' => $threadsQuery->orderBy('created_at', 'asc'),
            default => $threadsQuery->orderBy('is_pinned', 'desc')
                ->orderBy('last_post_at', 'desc'),
        };

        $threads = $threadsQuery->paginate(15);

        return view('livewire.pages.forum-category-page', [
            'threads' => $threads,
        ]);
    }
}
