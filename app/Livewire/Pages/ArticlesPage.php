<?php

namespace App\Livewire\Pages;

use App\Enums\ArticleStatus;
use App\Models\Article;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class ArticlesPage extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        $articles = Article::query()
            ->with('technologies')
            ->where('status', ArticleStatus::Published)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%'.$this->search.'%')
                        ->orWhere('content', 'like', '%'.$this->search.'%');
                });
            })
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        return view('livewire.pages.articles-page', [
            'articles' => $articles,
        ]);
    }
}
