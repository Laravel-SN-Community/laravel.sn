<?php

namespace App\Filament\Resources\Lessons\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LessonsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('chapter.name')
                    ->label('Chapitre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('chapter.course.name')
                    ->label('Cours')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('link')
                    ->label('Lien')
                    ->limit(30)
                    ->url(fn ($record) => $record->link, shouldOpenInNewTab: true)
                    ->toggleable(),

                TextColumn::make('summary')
                    ->limit(50)
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('links_count')
                    ->counts('links')
                    ->label('Liens')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('chapter_id')
                    ->label('Chapitre')
                    ->relationship('chapter', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
