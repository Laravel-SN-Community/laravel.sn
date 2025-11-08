<?php

namespace App\Filament\Resources\ForumThreads\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class ForumThreadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\IconColumn::make('is_pinned')
                    ->label('📌')
                    ->boolean()
                    ->alignCenter()
                    ->toggleable(),

                \Filament\Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                \Filament\Tables\Columns\TextColumn::make('category.name')
                    ->label('Catégorie')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn ($record) => $record->category?->color),

                \Filament\Tables\Columns\TextColumn::make('user.name')
                    ->label('Auteur')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('posts_count')
                    ->label('Réponses')
                    ->sortable()
                    ->alignCenter()
                    ->default(0),

                \Filament\Tables\Columns\TextColumn::make('views_count')
                    ->label('Vues')
                    ->sortable()
                    ->alignCenter()
                    ->default(0),

                \Filament\Tables\Columns\IconColumn::make('is_locked')
                    ->label('🔒')
                    ->boolean()
                    ->alignCenter()
                    ->toggleable(),

                \Filament\Tables\Columns\TextColumn::make('last_post_at')
                    ->label('Dernière activité')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->default(fn ($record) => $record->created_at),

                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Créée le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('forum_category_id')
                    ->label('Catégorie')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                \Filament\Tables\Filters\TernaryFilter::make('is_pinned')
                    ->label('Épinglée')
                    ->boolean()
                    ->trueLabel('Uniquement les discussions épinglées')
                    ->falseLabel('Uniquement les discussions non épinglées')
                    ->native(false),

                \Filament\Tables\Filters\TernaryFilter::make('is_locked')
                    ->label('Verrouillée')
                    ->boolean()
                    ->trueLabel('Uniquement les discussions verrouillées')
                    ->falseLabel('Uniquement les discussions ouvertes')
                    ->native(false),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('is_pinned', 'desc')
            ->defaultSort('last_post_at', 'desc');
    }
}
