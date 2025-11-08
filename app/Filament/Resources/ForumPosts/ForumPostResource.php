<?php

namespace App\Filament\Resources\ForumPosts;

use App\Filament\Resources\ForumPosts\Pages\CreateForumPost;
use App\Filament\Resources\ForumPosts\Pages\EditForumPost;
use App\Filament\Resources\ForumPosts\Pages\ListForumPosts;
use App\Filament\Resources\ForumPosts\Schemas\ForumPostForm;
use App\Filament\Resources\ForumPosts\Tables\ForumPostsTable;
use App\Models\ForumPost;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ForumPostResource extends Resource
{
    protected static ?string $model = ForumPost::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $recordTitleAttribute = 'content';

    public static function getNavigationGroup(): ?string
    {
        return 'Forum';
    }

    public static function getNavigationLabel(): string
    {
        return 'Messages';
    }

    public static function form(Schema $schema): Schema
    {
        return ForumPostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ForumPostsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListForumPosts::route('/'),
            'create' => CreateForumPost::route('/create'),
            'edit' => EditForumPost::route('/{record}/edit'),
        ];
    }
}
