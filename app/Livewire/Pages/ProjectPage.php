<?php

namespace App\Livewire\Pages;

use App\Enums\ProjectStatus;
use App\Models\Project;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectPage extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        $projects = Project::query()
            ->where('status', ProjectStatus::Approved)
            ->with('categories')
            ->with('technologies')
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
