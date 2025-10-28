<?php

namespace App\Livewire\Pages\Projects;

use App\Enums\ProjectStatus;
use App\Models\Category;
use App\Models\Project;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Facades\Auth;
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

        $this->closeModal();
        $this->resetPage();
        $this->dispatch('project-created');
    }

    public function deleteProject(int $projectId): void
    {
        Project::where('user_id', Auth::id())->findOrFail($projectId)->delete();
        $this->resetPage();
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                        if (($get('slug') ?? '') !== Str::slug($old)) {
                            return;
                        }
                        $set('slug', Str::slug($state));
                    })
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Select::make('category_id')
                    ->label('Category')
                    ->options(Category::pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->helperText('Select the category for your project')
                    ->columnSpanFull(),

                TextInput::make('github_url')
                    ->label('GitHub URL')
                    ->url()
                    ->required()
                    ->prefix('https://')
                    ->placeholder('github.com/username/repository')
                    ->helperText('The GitHub repository URL for this project')
                    ->columnSpanFull(),

                TextInput::make('demo_url')
                    ->label('Demo URL')
                    ->url()
                    ->prefix('https://')
                    ->placeholder('demo.example.com')
                    ->helperText('Optional: Live demo or project website URL')
                    ->columnSpanFull(),

                SpatieMediaLibraryFileUpload::make('screenshots')
                    ->collection('projects')
                    ->image()
                    ->imageEditor()
                    ->multiple()
                    ->reorderable()
                    ->maxFiles(5)
                    ->maxSize(5120)
                    ->helperText('Upload up to 5 screenshots of the project')
                    ->columnSpanFull(),

                MarkdownEditor::make('description')
                    ->required()
                    ->fileAttachmentsDirectory('projects')
                    ->fileAttachmentsDisk('public')
                    ->helperText('Detailed description of the project in Markdown format')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'link',
                        'bulletList',
                        'orderedList',
                        'codeBlock',
                    ]),
            ]);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $projects = Project::where('user_id', Auth::id())
            ->with('category')
            ->withCount(['votes', 'reviews'])
            ->latest()
            ->paginate(10);

        return view('livewire.pages.projects.create', compact('projects'));
    }
}