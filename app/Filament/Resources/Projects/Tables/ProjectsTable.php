<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->limit(50)
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('tags.name')
                    ->label('Tags')
                    ->badge()
                    ->separator(',')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        \App\Enums\ProjectStatus::Pending => 'danger',
                        \App\Enums\ProjectStatus::Approved => 'success',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('github_link')
                    ->label('GitHub')
                    ->url(fn ($record) => $record->github_link)
                    ->openUrlInNewTab()
                    ->icon('heroicon-m-link')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('project_link')
                    ->label('Project')
                    ->url(fn ($record) => $record->project_link)
                    ->openUrlInNewTab()
                    ->icon('heroicon-m-link')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
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
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->options(\App\Enums\ProjectStatus::class),
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
