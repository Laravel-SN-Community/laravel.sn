<?php

namespace App\Filament\Resources\LessonLinks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LessonLinksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lesson.name')
                    ->label('Leçon')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('lesson.chapter.name')
                    ->label('Chapitre')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('url')
                    ->label('URL')
                    ->limit(50)
                    ->url(fn ($record) => $record->url, shouldOpenInNewTab: true)
                    ->searchable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('lesson_id')
                    ->label('Leçon')
                    ->relationship('lesson', 'name')
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
