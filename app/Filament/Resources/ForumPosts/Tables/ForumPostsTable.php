<?php

namespace App\Filament\Resources\ForumPosts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class ForumPostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('thread.title')
                    ->label('Discussion')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                \Filament\Tables\Columns\TextColumn::make('user.name')
                    ->label('Auteur')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('content')
                    ->label('Contenu')
                    ->searchable()
                    ->limit(50)
                    ->html(),

                \Filament\Tables\Columns\IconColumn::make('is_solution')
                    ->label('✓ Solution')
                    ->boolean()
                    ->alignCenter()
                    ->toggleable(),

                \Filament\Tables\Columns\TextColumn::make('votes_count')
                    ->label('Votes')
                    ->sortable()
                    ->alignCenter()
                    ->default(0),

                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('edited_at')
                    ->label('Modifié le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('forum_thread_id')
                    ->label('Discussion')
                    ->relationship('thread', 'title')
                    ->searchable()
                    ->preload(),

                \Filament\Tables\Filters\SelectFilter::make('user_id')
                    ->label('Auteur')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),

                \Filament\Tables\Filters\TernaryFilter::make('is_solution')
                    ->label('Solution')
                    ->boolean()
                    ->trueLabel('Uniquement les solutions')
                    ->falseLabel('Uniquement les non-solutions')
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
            ->defaultSort('created_at', 'desc');
    }
}
