<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom de l\'événement')
                    ->required()
                    ->maxLength(255),
                DateTimePicker::make('date')
                    ->label('Date et heure')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y H:i'),
                TextInput::make('place')
                    ->label('Lieu')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Description')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                TextInput::make('rsvp_link')
                    ->label('Lien RSVP')
                    ->url()
                    ->maxLength(255),
                TextInput::make('event_link')
                    ->label('Lien de l\'événement')
                    ->url()
                    ->maxLength(255),
                Toggle::make('is_published')
                    ->label('Publié')
                    ->default(true),
            ]);
    }
}
