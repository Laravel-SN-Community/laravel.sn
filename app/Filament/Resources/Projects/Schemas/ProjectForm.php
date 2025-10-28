<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Enums\ProjectStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                SpatieMediaLibraryFileUpload::make('cover')
                    ->collection('projects')
                    ->image()
                    ->imageEditor()
                    ->maxSize(5120)
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('github_link')
                    ->url()
                    ->placeholder('https://github.com/username/repository'),
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
