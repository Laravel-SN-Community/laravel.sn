<?php

namespace App\Livewire\Pages\Projects;

use App\Enums\ProjectStatus;
use App\Models\Category;
use App\Models\Project;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Tags\Tag;
use Livewire\WithFileUploads;

class Create extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use WithFileUploads;

    public function createAction(): Action
    {
        return Action::make('create')
            ->label(__('Share your project'))
            ->modalHeading(__('Share your project with the community'))
            ->color('danger')
            ->icon(Heroicon::CodeBracket)
//            ->modalWidth('xl')
            ->schema([
                FileUpload::make('cover')
                    ->directory('projects-cover')
                    ->disk('public')
                    ->image()
                    ->imageEditor()
                    ->maxSize(5120)
                    ->visibility('public'),
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                MarkdownEditor::make('description')
                    ->label('Description')
                    ->fileAttachmentsDirectory('projects')
                    ->fileAttachmentsDisk('public')
                    ->required()
                    ->columnSpanFull(),
                Select::make('tags')
                    ->label('Tags')
                    ->options(
                        Tag::all()->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->required(),
                Select::make('categories')
                    ->label('Categories')
                    ->options(
                        Category::all()->pluck('name', 'id')
                    )
                    ->searchable()
                    ->preload()
                    ->multiple()
                    ->required(),
                TextInput::make('github_link')
                    ->label('Github Link')
                    ->maxLength(255),
                TextInput::make('project_link')
                    ->label('Project Link')
                    ->required()
                    ->maxLength(255),
            ])
            ->action(function ($data) {
                $project = Project::create([
                    'user_id' => auth()->user()->id,
//                    'slug' => Str::uuid()->toString(),
                    'slug' => Str::slug($data['name']) . '-' . Str::uuid()->toString(),
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'github_link' => $data['github_link'],
                    'project_link' => $data['project_link'],
                    'status' => ProjectStatus::Approved,
                ]);

                if (!empty($data['cover'])) {
                    $project->addMediaFromDisk($data['cover'], 'public')
                        ->toMediaCollection('projects');
                }

                $tags = Tag::whereIn('id', $data['tags'])->get();
                $project->attachTags($tags);

                $project->categories()->attach($data['categories']);
                $this->dispatch('project-created');
            })
            ->successNotificationTitle('Project created successfully');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.projects.create');
    }
}
