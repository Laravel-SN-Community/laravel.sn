<?php

namespace App\Filament\Resources\Articles\Tables;

use App\Enums\ArticleStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('slug')
                    ->limit(30)
                    ->searchable(),
                TextColumn::make('technologies.name')
                    ->label('Technologies')
                    ->badge()
                    ->separator(',')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('views_count')
                    ->label('Unique Views')
                    ->getStateUsing(fn ($record) => views($record)->unique()->count())
                    ->sortable(query: fn ($query, $direction) => $query->orderBy('id', $direction))
                    ->alignEnd(),
                TextColumn::make('status')
                    ->badge()
                    ->color(
                        fn ($state) => match ($state) {
                            ArticleStatus::Draft => 'danger',
                            ArticleStatus::Published => 'primary',
                            default => 'success',
                        }
                    )
                    ->searchable(),
                TextColumn::make('published_at')
                    ->placeholder('Unpublished')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('technologies')
                    ->relationship('technologies', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                SelectFilter::make('status')
                    ->options(ArticleStatus::class),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
