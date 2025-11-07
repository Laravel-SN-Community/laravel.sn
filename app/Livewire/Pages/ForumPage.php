<?php

namespace App\Livewire\Pages;

use App\Models\ForumCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ForumPage extends Component
{
    public $search = '';

    #[Layout('layouts.guest')]
    public function render()
    {
        $categories = ForumCategory::active()
            ->ordered()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%');
            })
            ->get()
            ->map(function ($category) {
                // Charger les statistiques pour chaque catégorie
                $category->loadCount('threads');

                return $category;
            });

        return view('livewire.pages.forum-page', [
            'categories' => $categories,
        ]);
    }
}
