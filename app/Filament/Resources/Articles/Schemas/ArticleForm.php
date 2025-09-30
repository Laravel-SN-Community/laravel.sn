<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Enums\ArticleStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                        if (($get('slug') ?? '') !== Str::slug($old)) {
                            return;
                        }
                        $set('slug', Str::slug($state));
                    })
                    ->required(),
                TextInput::make('slug')
                    ->scopedUnique()
                    ->required(),
                MarkdownEditor::make('content')
                    ->fileAttachmentsDirectory('articles')
                    ->fileAttachmentsDisk('public')
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(ArticleStatus::class)
                    ->default(ArticleStatus::Published)
                    ->required(),
//                DateTimePicker::make('published_at')
//                    ->nullable()
//                    ->after('status'),
            ]);
    }
}
