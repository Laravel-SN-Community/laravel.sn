<?php

namespace App\Models;

use App\Enums\ArticleStatus;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'slug', 'content', 'status', 'published_at'];
    protected $casts = [
        'status' => ArticleStatus::class,
    ];
}
