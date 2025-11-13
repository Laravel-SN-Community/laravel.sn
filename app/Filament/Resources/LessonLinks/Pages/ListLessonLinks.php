<?php

namespace App\Filament\Resources\LessonLinks\Pages;

use App\Filament\Resources\LessonLinks\LessonLinkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLessonLinks extends ListRecords
{
    protected static string $resource = LessonLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
