<?php

namespace App\Livewire\Pages\Projects;

use App\Models\Project;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

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
        $projects = Project::query()
            ->select(['id', 'user_id', 'title', 'slug', 'description', 'votes_count', 'average_rating', 'approved_at', 'created_at'])
            ->with(['user:id,name'])
            ->withCount(['votes', 'comments'])
            ->approved()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->sortBy === 'popular', function ($query) {
                $query->orderBy('votes_count', 'desc');
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
