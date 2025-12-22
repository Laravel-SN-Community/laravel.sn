<?php

namespace App\Filament\Resources\RssSources\Pages;

use App\Filament\Resources\RssSources\RssSourceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRssSources extends ListRecords
{
    protected static string $resource = RssSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

