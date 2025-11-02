<?php

namespace App\Livewire\Pages\Articles;

use App\Models\Article;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component implements HasForms, HasActions
{
    use WithPagination;
    use InteractsWithForms;
    use InteractsWithActions;

    public string $search = '';
    public $showDeleteModal = false;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function deleteArticle(int $articleId): void
    {
        $article = Article::where('id', $articleId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $article->delete();

        \Filament\Notifications\Notification::make()
            ->title('Article supprimé avec succès')
            ->success()
            ->send();
    }
    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->icon('heroicon-o-trash')
            ->requiresConfirmation()
            ->modalHeading('Supprimer l\'article')
            ->modalDescription('Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.')
            ->modalSubmitActionLabel('Oui, supprimer')
            ->modalCancelActionLabel('Annuler')
            ->color('danger')
            ->action(function (array $arguments) {
                $article = Article::where('id', $arguments['article'])
                    ->where('user_id', Auth::id())
                    ->firstOrFail();

                $article->delete();

                \Filament\Notifications\Notification::make()
                    ->title('Article supprimé avec succès')
                    ->success()
                    ->send();
            });
    }


    #[Layout('layouts.app')]
    public function render()
    {
        $articles = Article::query()
            ->where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('livewire.pages.articles.index', [
            'articles' => $articles,
        ]);
    }
}
