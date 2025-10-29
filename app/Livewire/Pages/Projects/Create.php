<?php

namespace App\Livewire\Pages\Projects;

use App\Enums\ProjectStatus;
use App\Models\Category;
use App\Models\Project;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public function createAction(): Action
    {
        return Action::make('create')
            ->label(__('Add a Project'))
            ->modalHeading(__('Add a new Project'))
            ->color('danger')
            ->icon(Heroicon::CodeBracket)
            ->modalWidth('xl')
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                MarkdownEditor::make('description')
                    ->label('Description')
                    ->required()
                    ->columnSpanFull(),
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
                    ->required()
                    ->maxLength(255),
                TextInput::make('project_link')
                    ->label('Project Link')
                    ->required()
                    ->maxLength(255),
            ])
            ->action(function ($data) {
                $project = Project::create([
                    'user_id' => auth()->user()->id,
                    'slug' => Str::slug($data['name']),
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'github_link' => $data['github_link'],
                    'project_link' => $data['project_link'],
                    'status' => ProjectStatus::Approved,
                ]);

                $project->categories()->attach($data['categories']);
            })
            ->successNotificationTitle('Project created successfully');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.projects.create');
    }
}
