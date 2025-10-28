<?php

namespace App\Livewire\Pages\Projects;

use App\Enums\ProjectStatus;
use App\Models\Project;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Schema;

class Index extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'sort')]
    public string $sortBy = 'latest'; // latest, popular, top_rated

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingSortBy(): void
    {
        $this->resetPage();
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        $query = Project::query()
            ->select(['id', 'user_id', 'title', 'slug', 'description', 'votes_count', 'average_rating', 'approved_at', 'created_at'])
            ->with(['user:id,name'])
            ->approved();

        // only add withCount when the underlying tables exist (sqlite/dev may not have all migrations)
        $hasVotes = Schema::hasTable('project_votes');
        $hasReviews = Schema::hasTable('project_reviews');

        if ($hasVotes || $hasReviews) {
            $counts = [];
            if ($hasVotes) {
                $counts[] = 'votes';
            }
            if ($hasReviews) {
                $counts[] = 'reviews';
            }

            $query = $query->withCount($counts);
        }

        $projects = $query
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->sortBy === 'popular', function ($q) use ($hasVotes) {
                // if votes_count isn't available (missing table), fallback to approved_at
                if ($hasVotes) {
                    $q->orderBy('votes_count', 'desc');
                } else {
                    $q->orderBy('approved_at', 'desc');
                }
            })
            ->when($this->sortBy === 'top_rated', function ($query) {
                $query->orderBy('average_rating', 'desc');
            })
            ->when($this->sortBy === 'latest', function ($query) {
                $query->orderBy('approved_at', 'desc');
            })
            ->paginate(12);

        return view('livewire.pages.projects.index', [
            'projects' => $projects,
        ])->title('Community Projects');
    }
}
