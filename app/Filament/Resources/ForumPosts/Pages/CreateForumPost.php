<?php

namespace App\Filament\Resources\ForumPosts\Pages;

use App\Filament\Resources\ForumPosts\ForumPostResource;
use Filament\Resources\Pages\CreateRecord;

class CreateForumPost extends CreateRecord
{
    protected static string $resource = ForumPostResource::class;
}
