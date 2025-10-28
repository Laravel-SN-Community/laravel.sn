<?php

namespace App\Livewire\Pages\Projects;

use App\Models\Project;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Layout('layouts.app')]
    public function render()
    {
        /** @var int $userId */
        $userId = auth()->user()?->id;

        $projects = Project::query()
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('livewire.pages.projects.index', [
            'projects' => $projects,
        ]);
    }
}
