<?php

namespace App\Livewire\Pages\Projects;

use App\Models\Project;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Show extends Component
{
    public Project $project;

    public function mount(Project $project): void
    {
        $this->project = $project->load(['user', 'categories', 'tags', 'votes']);
    }

    public function toggleVote(int $projectId): void
    {
        $user = auth()->user();

        /** @var \App\Models\Project $project */
        $project = Project::findOrFail($projectId);

        if ($user->hasVotedFor($project)) {
            $user->votes()->detach($project);
        } else {
            $user->votes()->attach($project);
        }
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.pages.projects.show');
    }
}
