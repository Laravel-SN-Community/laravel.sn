<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Enums\ProjectStatus;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                SpatieMediaLibraryFileUpload::make('cover')
                    ->collection('projects')
                    ->disk('public')
                    ->image()
                    ->imageEditor(),
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                        if (($get('slug') ?? '') !== Str::slug($old)) {
                            return;
                        }
                        $set('slug', Str::slug($state));
                    })
                    ->maxLength(255),
                TextInput::make('slug')
                    ->scopedUnique()
                    ->required(),
                TextInput::make('github_link')
                    ->url()
                    ->placeholder('https://github.com/username/repository'),
                MarkdownEditor::make('description')
                    ->fileAttachmentsDirectory('projects')
                    ->fileAttachmentsDisk('public')
                    ->required()
                    ->columnSpanFull(),
                SpatieTagsInput::make('tags')
                    ->label('Tags')
                    ->type('project')
                    ->suggestions(fn () => \Spatie\Tags\Tag::where('type', 'project')->pluck('name')->toArray())
                    ->helperText('Add tags for this project (e.g., Laravel, React, Docker). Press Enter or comma to add multiple tags.'),
                TextInput::make('project_link')
                    ->url()
                    ->placeholder('https://example.com'),
                Select::make('status')
                    ->options(ProjectStatus::class)
                    ->default(ProjectStatus::Pending)
                    ->required(),
                Select::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }
}
