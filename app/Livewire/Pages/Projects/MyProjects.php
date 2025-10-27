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
use Masmerise\Toaster\Toaster;

class MyProjects extends Component
{
    use WithPagination;
    use WithFileUploads;

    // Modal state
    public bool $showModal = false;

    // Form fields
    public string $title = '';
    public string $description = '';
    public string $github_url = '';
    public string $demo_url = '';
    public array $screenshots = [];
    public ?int $category_id = null;
    public string $new_category_name = '';

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:projects,title',
            'description' => 'required|string|min:100',
            'github_url' => 'required|url|regex:/github\.com/',
            'demo_url' => 'nullable|url',
            'screenshots.*' => 'nullable|image|max:5120',
            'category_id' => 'nullable|exists:categories,id',
            'new_category_name' => 'nullable|string|max:255|unique:categories,name',
        ];
    }

    public function openModal(): void
    {
        $this->showModal = true;
        $this->reset(['title', 'description', 'github_url', 'demo_url', 'screenshots', 'category_id', 'new_category_name']);
        $this->resetValidation();
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['title', 'description', 'github_url', 'demo_url', 'screenshots', 'category_id', 'new_category_name']);
        $this->resetValidation();
    }

    public function submit(): void
    {
        $this->validate();

        // Handle category: create new if name provided, otherwise use selected
        $categoryId = $this->category_id;

        if (!empty($this->new_category_name)) {
            // Check if category already exists
            $category = Category::firstOrCreate(
                ['name' => $this->new_category_name],
                ['slug' => Str::slug($this->new_category_name)]
            );
            $categoryId = $category->id;
        }

        $project = Project::create([
            'user_id' => Auth::id(),
            'category_id' => $categoryId,
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'github_url' => $this->github_url,
            'demo_url' => $this->demo_url,
            'status' => ProjectStatus::Pending,
        ]);

        // Upload screenshots if any
        if (! empty($this->screenshots)) {
            foreach ($this->screenshots as $screenshot) {
                $project->addMedia($screenshot->getRealPath())
                    ->usingFileName($screenshot->getClientOriginalName())
                    ->toMediaCollection('projects');
            }
        }

        $this->closeModal();
        Toaster::success('Votre projet a été soumis avec succès ! Il sera visible après validation par un modérateur.');

        // Refresh the list
        $this->resetPage();
    }

    public function deleteProject(int $projectId): void
    {
        $project = Project::findOrFail($projectId);

        if ($project->user_id !== Auth::id()) {
            Toaster::error('Vous ne pouvez supprimer que vos propres projets.');
            return;
        }

        $project->delete();
        Toaster::success('Projet supprimé avec succès.');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $projects = Project::query()
            ->where('user_id', Auth::id())
            ->with('category')
            ->withCount(['votes', 'reviews'])
            ->latest()
            ->paginate(10);

        $categories = Category::orderBy('name')->get();

        return view('livewire.pages.projects.my-projects', [
            'projects' => $projects,
            'categories' => $categories,
        ])->title('Mes Projets');
    }
}
