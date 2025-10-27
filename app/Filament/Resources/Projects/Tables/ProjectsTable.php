<?php

namespace App\Filament\Resources\Projects\Tables;

use App\Enums\ProjectStatus;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->collection('projects')
                    ->label('Preview')
                    ->square()
                    ->limit(1),

                TextColumn::make('title')
                    ->limit(40)
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Owner')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        ProjectStatus::Pending => 'warning',
                        ProjectStatus::Approved => 'success',
                        ProjectStatus::Rejected => 'danger',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('votes_count')
                    ->label('Votes')
                    ->alignEnd()
                    ->sortable(),

                TextColumn::make('average_rating')
                    ->label('Rating')
                    ->suffix('/5')
                    ->alignEnd()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable()
                    ->since(),

                TextColumn::make('approved_at')
                    ->label('Approved')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(ProjectStatus::class)
                    ->default(ProjectStatus::Pending->value),

                SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

                Action::make('approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->status !== ProjectStatus::Approved)
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $record->update([
                            'status' => ProjectStatus::Approved,
                            'approved_at' => now(),
                            'rejection_reason' => null,
                        ]);

                        Notification::make()
                            ->title('Project Approved')
                            ->body("The project \"{$record->title}\" has been approved.")
                            ->success()
                            ->send();

                        // TODO: Send notification to project owner
                    }),

                Action::make('reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => $record->status !== ProjectStatus::Rejected)
                    ->form([
                        Textarea::make('rejection_reason')
                            ->label('Rejection Reason')
                            ->required()
                            ->helperText('Explain why this project is being rejected'),
                    ])
                    ->requiresConfirmation()
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status' => ProjectStatus::Rejected,
                            'rejection_reason' => $data['rejection_reason'],
                            'approved_at' => null,
                        ]);

                        Notification::make()
                            ->title('Project Rejected')
                            ->body("The project \"{$record->title}\" has been rejected.")
                            ->warning()
                            ->send();

                        // TODO: Send notification to project owner
                    }),

                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
