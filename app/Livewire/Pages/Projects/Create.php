<?php

namespace App\Livewire\Pages\Projects;

use App\Enums\ProjectStatus;
use App\Models\Category;
use App\Models\Project;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component implements HasForms
{
    use WithPagination, InteractsWithForms;

    public bool $showModal = false;
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function openModal(): void
    {
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset('data');
        $this->form->fill();
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        $project = Project::create([
            'user_id' => Auth::id(),
            'title' => $data['title'],
            'slug' => $data['slug'],
            'category_id' => $data['category_id'],
            'github_url' => $data['github_url'],
            'demo_url' => $data['demo_url'] ?? null,
            'description' => $data['description'],
            'status' => ProjectStatus::Pending,
        ]);

        if (isset($data['screenshots'])) {
            foreach ($data['screenshots'] as $file) {
                $project->addMedia($file)->toMediaCollection('projects');
            }
        }

        // Clear cache for user's projects
        Cache::forget('user_projects_' . Auth::id());

        $this->closeModal();
        $this->resetPage();
        $this->dispatch('project-created');
    }

    public function deleteProject(int $projectId): void
    {
        Project::where('user_id', Auth::id())->findOrFail($projectId)->delete();

        // Clear cache for user's projects
        Cache::forget('user_projects_' . Auth::id());

        $this->resetPage();
    }

    public function form($form): Schema
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Project Title')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                        if (($get('slug') ?? '') !== Str::slug($old)) {
                            return;
                        }
                        $set('slug', Str::slug($state));
                    })
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Enter your project title')
                    ->columnSpanFull(),

                TextInput::make('slug')
                    ->label('URL Slug')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('auto-generated-from-title')
                    ->helperText('This will be used in the project URL')
                    ->columnSpanFull(),

                Select::make('category_id')
                    ->label('Project Category')
                    ->options(Cache::remember('categories_list', 3600, function () { // Cache for 1 hour
                        return Category::pluck('name', 'id');
                    }))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->placeholder('Choose a category')
                    ->helperText('Select the most appropriate category for your project')
                    ->columnSpanFull(),

                TextInput::make('github_url')
                    ->label('GitHub Repository')
                    ->url()
                    ->required()
                    ->prefix('https://')
                    ->placeholder('github.com/username/repository')
                    ->helperText('Link to your project\'s GitHub repository')
                    ->columnSpanFull(),

                TextInput::make('demo_url')
                    ->label('Live Demo')
                    ->url()
                    ->prefix('https://')
                    ->placeholder('demo.example.com')
                    ->helperText('Optional: Link to a live demo or project website')
                    ->columnSpanFull(),

                SpatieMediaLibraryFileUpload::make('screenshots')
                    ->label('Project Screenshots')
                    ->collection('projects')
                    ->image()
                    ->imageEditor()
                    ->multiple()
                    ->reorderable()
                    ->maxFiles(5)
                    ->maxSize(5120)
                    ->helperText('Upload up to 5 screenshots showcasing your project (max 5MB each)')
                    ->columnSpanFull()
                    ->panelLayout('grid'),

                RichEditor::make('description')
                    ->label('Project Description')
                    ->required()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'link',
                        'bulletList',
                        'orderedList',
                        'h2',
                        'h3',
                        'blockquote',
                    ])
                    ->placeholder('<h2>About This Project</h2><p>Describe what your project does, its features, and how to use it.</p><h3>Key Features</h3><ul><li>Feature 1</li><li>Feature 2</li><li>Feature 3</li></ul><h3>Technologies Used</h3><ul><li>Tech 1</li><li>Tech 2</li><li>Tech 3</li></ul>')
                    ->columnSpanFull(),
            ])
            ->columns(1)
            ->statePath('data');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $cacheKey = 'user_projects_' . Auth::id() . '_page_' . $this->getPage();

        $projects = Cache::remember($cacheKey, 300, function () { // Cache for 5 minutes
            return Project::where('user_id', Auth::id())
                ->with('category')
                ->withCount(['votes', 'comments'])
                ->latest()
                ->paginate(10);
        });

        return view('livewire.pages.projects.create', compact('projects'));
    }
}