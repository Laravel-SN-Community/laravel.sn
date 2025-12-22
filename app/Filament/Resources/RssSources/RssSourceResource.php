<?php

namespace App\Filament\Resources\RssSources;

use App\Filament\Resources\RssSources\Pages\CreateRssSource;
use App\Filament\Resources\RssSources\Pages\EditRssSource;
use App\Filament\Resources\RssSources\Pages\ListRssSources;
use App\Filament\Resources\RssSources\Schemas\RssSourceForm;
use App\Filament\Resources\RssSources\Tables\RssSourcesTable;
use App\Models\RssSource;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RssSourceResource extends Resource
{
    protected static ?string $model = RssSource::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRss;

    public static function form(Schema $schema): Schema
    {
        return RssSourceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RssSourcesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRssSources::route('/'),
            'create' => CreateRssSource::route('/create'),
            'edit' => EditRssSource::route('/{record}/edit'),
        ];
    }
}
