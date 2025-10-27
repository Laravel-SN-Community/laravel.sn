<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Enums\ProjectStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
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
                Select::make('user_id')
                    ->label('Project Owner')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->helperText('Select the user who submitted this project'),

                TextInput::make('title')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                        if (($get('slug') ?? '') !== Str::slug($old)) {
                            return;
                        }
                        $set('slug', Str::slug($state));
                    })
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->scopedUnique()
                    ->required()
                    ->maxLength(255),

                TextInput::make('github_url')
                    ->label('GitHub URL')
                    ->url()
                    ->required()
                    ->prefix('https://')
                    ->placeholder('github.com/username/repository')
                    ->helperText('The GitHub repository URL for this project'),

                TextInput::make('demo_url')
                    ->label('Demo URL')
                    ->url()
                    ->prefix('https://')
                    ->placeholder('demo.example.com')
                    ->helperText('Optional: Live demo or project website URL'),

                Select::make('status')
                    ->options(ProjectStatus::class)
                    ->default(ProjectStatus::Pending->value)
                    ->required()
                    ->helperText('Approve or reject this project submission'),

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
                    ->columnSpanFull(),

                Textarea::make('rejection_reason')
                    ->label('Rejection Reason')
                    ->helperText('If rejecting, provide a reason for the project owner')
                    ->visible(fn (Get $get) => $get('status') === ProjectStatus::Rejected->value)
                    ->required(fn (Get $get) => $get('status') === ProjectStatus::Rejected->value)
                    ->columnSpanFull(),

                DateTimePicker::make('approved_at')
                    ->label('Approved Date')
                    ->helperText('Automatically set when project is approved')
                    ->disabled()
                    ->dehydrated(false),
            ]);
    }
}
