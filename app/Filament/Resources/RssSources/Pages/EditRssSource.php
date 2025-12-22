<?php

namespace App\Filament\Resources\RssSources\Pages;

use App\Filament\Resources\RssSources\RssSourceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRssSource extends EditRecord
{
    protected static string $resource = RssSourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

