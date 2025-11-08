<?php

namespace App\Filament\Resources\ForumPosts\Schemas;

use Filament\Schemas\Schema;

class ForumPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('forum_thread_id')
                    ->label('Discussion')
                    ->relationship('thread', 'title')
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

                \Filament\Forms\Components\Select::make('parent_id')
                    ->label('Réponse à')
                    ->relationship('parent', 'content')
                    ->searchable()
                    ->preload()
                    ->helperText('Laisser vide si c\'est un message principal'),

                \Filament\Forms\Components\RichEditor::make('content')
                    ->label('Contenu')
                    ->required()
                    ->columnSpanFull(),

                \Filament\Forms\Components\Toggle::make('is_solution')
                    ->label('Marquer comme solution')
                    ->default(false)
                    ->helperText('Ce message résout-il la discussion ?'),
            ]);
    }
}
