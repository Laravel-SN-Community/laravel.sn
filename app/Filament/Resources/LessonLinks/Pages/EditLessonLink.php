<?php

namespace App\Filament\Resources\LessonLinks\Pages;

use App\Filament\Resources\LessonLinks\LessonLinkResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLessonLink extends EditRecord
{
    protected static string $resource = LessonLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
