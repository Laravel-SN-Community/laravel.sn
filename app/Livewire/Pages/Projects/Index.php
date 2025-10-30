<?php

namespace App\Livewire\Pages\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function toggleVote(int $projectId): void
    {
        $user = auth()->user();

        /** @var \App\Models\Project $project */
        $project = Project::findOrFail($projectId);

        if ($user->hasVotedFor($project)) {
            $user->votedProjects()->detach($project);
        } else {
            $user->votedProjects()->attach($project);
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        /** @var int $userId */
        $userId = Auth::user()?->id;

        $projects = Project::query()
            ->with('categories')
            ->withCount('votes')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('livewire.pages.projects.index', [
            'projects' => $projects,
        ]);
    }
}
