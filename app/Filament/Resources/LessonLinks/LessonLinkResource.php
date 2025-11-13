<?php

namespace App\Filament\Resources\LessonLinks;

use App\Filament\Resources\LessonLinks\Pages\CreateLessonLink;
use App\Filament\Resources\LessonLinks\Pages\EditLessonLink;
use App\Filament\Resources\LessonLinks\Pages\ListLessonLinks;
use App\Filament\Resources\LessonLinks\Schemas\LessonLinkForm;
use App\Filament\Resources\LessonLinks\Tables\LessonLinksTable;
use App\Models\LessonLink;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LessonLinkResource extends Resource
{
    protected static ?string $model = LessonLink::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLink;

    protected static ?string $navigationLabel = 'Liens';

    protected static ?string $modelLabel = 'lien';

    protected static ?string $pluralModelLabel = 'liens';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return LessonLinkForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LessonLinksTable::configure($table);
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
            'index' => ListLessonLinks::route('/'),
            'create' => CreateLessonLink::route('/create'),
            'edit' => EditLessonLink::route('/{record}/edit'),
        ];
    }
}
