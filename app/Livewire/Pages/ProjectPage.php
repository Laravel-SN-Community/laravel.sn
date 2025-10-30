<?php

namespace App\Livewire\Pages;

use App\Enums\ProjectStatus;
use App\Models\Project;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class ProjectPage extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function toggleVote(int $projectId): void
    {
        $user = auth()->user();

        if (! $user) {
            session()->put('url.intended', url()->previous());
            session()->put('pending_vote_project_id', $projectId);
            $this->redirect(route('login'));

            return;
        }

        /** @var \App\Models\Project $project */
        $project = Project::findOrFail($projectId);

        if ($user->hasVotedFor($project)) {
            $user->votedProjects()->detach($project);
            Toaster::error(__('You Downvoted this project. 😭😭'));
        } else {
            $user->votedProjects()->attach($project);
            Toaster::success(__('You Upvoted this project. 🔥🔥🔥'));
        }
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        $projects = Project::query()
            ->where('status', ProjectStatus::Approved)
            ->with('categories')
            ->with('technologies')
            ->withCount('votes')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('description', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.pages.project-page', [
            'projects' => $projects,
        ]);
    }
}
