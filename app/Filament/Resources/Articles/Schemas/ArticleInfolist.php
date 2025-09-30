<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Enums\ArticleStatus;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Support\Enums\FontWeight;
use Filament\Schemas\Schema;;

class ArticleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columns(1)
                    ->schema([
                        Section::make('Main Information')
                            ->description('Item details')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('title')
                                            ->size('large')
                                            ->weight(FontWeight::Bold)
                                            ->color('primary')
                                            ->icon('heroicon-m-pencil-square')
                                            ->columnSpanFull(),

                                        TextEntry::make('slug')
                                            ->label('URL')
                                            ->icon('heroicon-m-link')
                                            ->copyable()
                                            ->copyMessage('Slug copié!')
                                            ->copyMessageDuration(1500)
                                            ->badge()
                                            ->color('gray'),

                                        TextEntry::make('status')
                                            ->badge()
                                            ->icon('heroicon-m-flag')
                                            ->color(
                                                fn ($state) => match ($state) {
                                                    ArticleStatus::Draft => 'danger',
                                                    ArticleStatus::Published => 'primary',
                                                    default => 'success',
                                                }
                                            )
                                    ]),
                            ])
                            ->collapsible(),
                        Section::make('Metadata')
                            ->description('Date and System Information')
                            ->icon('heroicon-o-clock')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextEntry::make('published_at')
                                            ->label('Publication date')
                                            ->dateTime('d/m/Y à H:i')
                                            ->icon('heroicon-m-calendar')
                                            ->color('success')
                                            ->placeholder('Unpublished'),

                                        TextEntry::make('created_at')
                                            ->label('Created on')
                                            ->dateTime('d/m/Y à H:i')
                                            ->icon('heroicon-m-plus-circle')
                                            ->color('info'),

                                        TextEntry::make('updated_at')
                                            ->label('Modified on')
                                            ->dateTime('d/m/Y à H:i')
                                            ->icon('heroicon-m-arrow-path')
                                            ->color('warning')
                                            ->since(),
                                    ]),
                            ])
                            ->collapsible()
                            ->collapsed(true),
                    ]),

                Section::make('Content')
                    ->description('Article body')
                    ->icon('heroicon-o-document')
                    ->schema([
                        TextEntry::make('content')
                            ->label('Full text')
                            ->markdown()
                            ->prose()
                            ->columnSpanFull()
                            ->extraAttributes([
                                'class' => 'prose prose-sm max-w-none dark:prose-invert',
                                'style' => 'max-height: 500px; overflow-y: auto; padding: 1rem; border-radius: 0.5rem;'
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(false),

            ]);
    }
}
