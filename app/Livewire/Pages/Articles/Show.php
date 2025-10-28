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

        // Record unique view but throttle for fewer DB writes.
        try {
            views($article)->cooldown(now()->addMinutes(30))->record();
        } catch (\Throwable $e) {
            report($e);
        }
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        $viewsCount = 0;
        try {
            $viewsCount = views($this->article)->unique()->count();
        } catch (\Throwable $e) {
            report($e);
        }

        return view('livewire.pages.articles.show', [
            'viewsCount' => $viewsCount,
        ]);
    }
}
