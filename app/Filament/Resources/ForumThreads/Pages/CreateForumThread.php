<?php

namespace App\Filament\Resources\ForumThreads\Pages;

use App\Filament\Resources\ForumThreads\ForumThreadResource;
use Filament\Resources\Pages\CreateRecord;

class CreateForumThread extends CreateRecord
{
    protected static string $resource = ForumThreadResource::class;
}
