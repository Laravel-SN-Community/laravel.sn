<?php

namespace App\Filament\Resources\LessonLinks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LessonLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('lesson_id')
                    ->label('Leçon')
                    ->relationship('lesson', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                TextInput::make('title')
                    ->label('Titre')
                    ->required()
                    ->maxLength(255),

                TextInput::make('url')
                    ->label('URL')
                    ->required()
                    ->url()
                    ->maxLength(255),
            ]);
    }
}
