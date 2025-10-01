<?php

namespace App\Observers;

use App\Enums\ArticleStatus;
use App\Models\Article;

class ArticleObserver
{
    public function saving(Article $article): void
    {
        if ($article->status === ArticleStatus::Published && is_null($article->published_at)) {
            $article->published_at = now();
        }
    }
}
