<?php

namespace App\Filament\Resources\ForumThreads\Schemas;

use Filament\Schemas\Schema;

class ForumThreadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('forum_category_id')
                    ->label('Catégorie')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                \Filament\Forms\Components\Select::make('user_id')
                    ->label('Auteur')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->default(auth()->id()),

                \Filament\Forms\Components\TextInput::make('title')
                    ->label('Titre')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

                \Filament\Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Génération automatique à partir du titre'),

                \Filament\Forms\Components\RichEditor::make('content')
                    ->label('Contenu')
                    ->required()
                    ->columnSpanFull(),

                \Filament\Forms\Components\Toggle::make('is_pinned')
                    ->label('Épinglée')
                    ->default(false)
                    ->helperText('Les discussions épinglées apparaissent en haut de la liste'),

                \Filament\Forms\Components\Toggle::make('is_locked')
                    ->label('Verrouillée')
                    ->default(false)
                    ->helperText('Les discussions verrouillées ne peuvent plus recevoir de réponses'),
            ]);
    }
}
