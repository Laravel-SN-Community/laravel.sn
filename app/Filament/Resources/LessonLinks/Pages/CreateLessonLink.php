<?php

namespace App\Filament\Resources\LessonLinks\Pages;

use App\Filament\Resources\LessonLinks\LessonLinkResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLessonLink extends CreateRecord
{
    protected static string $resource = LessonLinkResource::class;
}
