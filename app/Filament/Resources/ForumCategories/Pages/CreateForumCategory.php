<?php

namespace App\Filament\Resources\ForumCategories\Pages;

use App\Filament\Resources\ForumCategories\ForumCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateForumCategory extends CreateRecord
{
    protected static string $resource = ForumCategoryResource::class;
}
