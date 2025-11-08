<?php

namespace App\Livewire\Pages;

use App\Models\ForumCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class ForumThreadCreate extends Component
{
    public ForumCategory $category;
    public string $title = '';
    public string $content = '';

    public function mount($slug)
    {
        $this->category = ForumCategory::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
    }

    public function createThread()
    {
        $this->validate([
            'title' => 'required|min:10|max:255',
            'content' => 'required|min:20',
        ]);

        $thread = $this->category->threads()->create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'content' => $this->content,
        ]);

        session()->flash('success', 'Discussion créée avec succès !');

        return redirect()->route('forum.thread.show', [$this->category->slug, $thread->slug]);
    }

    public function render()
    {
        return view('livewire.pages.forum-thread-create');
    }
}
