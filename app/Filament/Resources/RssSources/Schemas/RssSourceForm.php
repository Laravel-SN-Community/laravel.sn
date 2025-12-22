<?php

namespace App\Filament\Resources\RssSources\Schemas;

use App\Models\RssSource;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RssSourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Source Name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g., Laravel News'),

                TextInput::make('feed_url')
                    ->label('Feed URL')
                    ->required()
                    ->url()
                    ->maxLength(255)
                    ->placeholder('https://example.com/feed.xml')
                    ->unique(RssSource::class, 'feed_url', ignoreRecord: true),

                Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->maxLength(500)
                    ->placeholder('Optional description of this feed source'),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
                    ->helperText('Only active sources will be displayed in the feeds page'),
            ]);
    }
}
