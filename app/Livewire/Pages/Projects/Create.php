<?php

namespace App\Livewire\Pages\Projects;

use App\Enums\ProjectStatus;
use App\Models\Project;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public function createAction(): Action
    {
        return Action::make('create')
            ->label('Create')
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                MarkdownEditor::make('description')
                    ->label('Description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('github_link')
                    ->label('Github Link')
                    ->required()
                    ->maxLength(255),
                TextInput::make('project_link')
                    ->label('Project Link')
                    ->required()
                    ->maxLength(255),
                SpatieMediaLibraryFileUpload::make('cover')
                    ->label('Cover Image')
                    ->collection('projects')
                    ->required()
                    ->image()
                    ->imageEditor()
                    ->maxSize(5120)
                    ->columnSpanFull(),
            ])
            ->action(function ($data) {
                $project = Project::create([
                    'user_id' => auth()->user()->id,
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'github_link' => $data['github_link'],
                    'project_link' => $data['project_link'],
                    'status' => ProjectStatus::Approved,
                ]);

                if (isset($data['cover']) && $data['cover']) {
                    $project->addMedia($data['cover'])
                        ->toMediaCollection('projects');
                }
            })
            ->successNotificationTitle('Project created successfully')
            ->icon('heroicon-o-plus');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.projects.create');
    }
}
