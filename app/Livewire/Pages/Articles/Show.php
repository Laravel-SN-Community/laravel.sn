<?php

namespace App\Livewire\Pages\Articles;

use App\Enums\ArticleStatus;
use App\Models\Article;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public Article $article;

    public function mount(Article $article): void
    {
        // Only allow published articles to be viewed
        if ($article->status !== ArticleStatus::Published) {
            abort(404);
        }

        $this->article = $article;
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.pages.articles.show');
    }
}
