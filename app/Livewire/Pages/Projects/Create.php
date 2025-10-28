<?php

namespace App\Livewire\Pages\Projects;

use App\Enums\ProjectStatus;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Create extends Component
{
    use WithFileUploads, WithPagination;

    public bool $showModal = false;
    public ?array $data = [];
    public $screenshots = [];

    public function mount(): void
    {
        $this->data = [];
    }

    public function openModal(): void
    {
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset('data', 'screenshots');
    }

    public function submit(): void
    {
        $validated = $this->validate([
            'data.title' => 'required|string|max:255',
            'data.slug' => 'required|string|max:255',
            'data.category_id' => 'required|exists:categories,id',
            'data.github_url' => 'required|url',
            'data.demo_url' => 'nullable|url',
            'data.description' => 'required|string',
            'screenshots.*' => 'nullable|image|max:5120', // 5MB max per image
        ]);

        $project = Project::create([
            'user_id' => Auth::id(),
            'title' => $validated['data']['title'],
            'slug' => $validated['data']['slug'],
            'category_id' => $validated['data']['category_id'],
            'github_url' => $validated['data']['github_url'],
            'demo_url' => $validated['data']['demo_url'] ?? null,
            'description' => $validated['data']['description'],
            'status' => ProjectStatus::Pending,
        ]);

        // Handle file uploads if screenshots are provided
        if ($this->screenshots) {
            foreach ($this->screenshots as $screenshot) {
                $project->addMedia($screenshot->getRealPath())
                    ->usingName($screenshot->getClientOriginalName())
                    ->toMediaCollection('screenshots');
            }
        }

        $this->closeModal();
        $this->resetPage();
        $this->dispatch('project-created');
    }

    public function deleteProject(int $projectId): void
    {
        Project::where('user_id', Auth::id())->findOrFail($projectId)->delete();

        $this->resetPage();
    }



    #[Layout('layouts.app')]
    public function render()
    {
        $projects = Project::where('user_id', Auth::id())
            ->with('category')
            ->withCount(['votes', 'comments'])
            ->latest()
            ->paginate(10);

        return view('livewire.pages.projects.create', compact('projects'));
    }
}