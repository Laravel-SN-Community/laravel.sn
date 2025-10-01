<?php

namespace App\Models;

use App\Enums\ArticleStatus;
use App\Observers\ArticleObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([ArticleObserver::class])]
class Article extends Model
{
    protected $fillable = ['title', 'slug', 'content', 'status', 'published_at'];

    protected $casts = [
        'status' => ArticleStatus::class,
        'published_at' => 'datetime',
    ];
}
