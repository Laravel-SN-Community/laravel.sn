<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProjectInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Project Information')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('title'),
                        TextEntry::make('slug'),
                        TextEntry::make('user.name')
                            ->label('Owner'),
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn ($state) => match ($state->value) {
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('github_url')
                            ->label('GitHub URL')
                            ->url(fn ($record) => $record->github_url)
                            ->openUrlInNewTab()
                            ->columnSpanFull(),
                        TextEntry::make('demo_url')
                            ->label('Demo URL')
                            ->url(fn ($record) => $record->demo_url)
                            ->openUrlInNewTab()
                            ->placeholder('No demo URL provided')
                            ->columnSpanFull(),
                    ]),

                Section::make('Description')
                    ->schema([
                        TextEntry::make('description')
                            ->markdown()
                            ->columnSpanFull(),
                    ]),

                Section::make('Screenshots')
                    ->schema([
                        SpatieMediaLibraryImageEntry::make('screenshots')
                            ->collection('projects')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record) => $record->getMedia('projects')->isNotEmpty()),

                Section::make('Statistics')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('votes_count')
                            ->label('Total Votes'),
                        TextEntry::make('average_rating')
                            ->label('Average Rating')
                            ->suffix(' / 5'),
                        TextEntry::make('reviews.count')
                            ->label('Total Reviews')
                            ->state(fn ($record) => $record->reviews()->count()),
                    ]),

                Section::make('Moderation')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('approved_at')
                            ->label('Approved Date')
                            ->dateTime()
                            ->placeholder('Not approved yet'),
                        TextEntry::make('rejection_reason')
                            ->label('Rejection Reason')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                    ]),

                Section::make('Timestamps')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('created_at')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->dateTime(),
                    ])
                    ->collapsible(),
            ]);
    }
}
