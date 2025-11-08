<?php

namespace App\Filament\Resources\ForumCategories\Schemas;

use Filament\Schemas\Schema;

class ForumCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('name')
                    ->label('Nom')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

                \Filament\Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Génération automatique à partir du nom'),

                \Filament\Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->columnSpanFull(),

                \Filament\Forms\Components\ColorPicker::make('color')
                    ->label('Couleur')
                    ->helperText('Couleur d\'affichage de la catégorie'),

                \Filament\Forms\Components\TextInput::make('icon')
                    ->label('Icône')
                    ->maxLength(255)
                    ->helperText('Nom de l\'icône Heroicon (ex: chat-bubble-left-right)'),

                \Filament\Forms\Components\TextInput::make('sort_order')
                    ->label('Ordre de tri')
                    ->numeric()
                    ->default(0)
                    ->required(),

                \Filament\Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->required(),
            ]);
    }
}
