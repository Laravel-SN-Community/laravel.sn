<?php

namespace App\Livewire\Pages;

use App\Models\ForumCategory;
use App\Models\ForumThread;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest')]
class ForumThreadPage extends Component
{
    public $categoryId;
    public $threadId;
    public string $reply = '';

    public function mount($category, $thread)
    {
        $cat = ForumCategory::where('slug', $category)
            ->where('is_active', true)
            ->firstOrFail();

        $thr = ForumThread::where('slug', $thread)
            ->where('forum_category_id', $cat->id)
            ->firstOrFail();

        $this->categoryId = $cat->id;
        $this->threadId = $thr->id;

        // Increment views
        $thr->incrementViews();
    }

    public function getThreadProperty()
    {
        return ForumThread::with(['user', 'category'])->findOrFail($this->threadId);
    }

    public function getCategoryProperty()
    {
        return ForumCategory::findOrFail($this->categoryId);
    }

    public function postReply()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->validate([
            'reply' => 'required|min:10',
        ]);

        if ($this->thread->is_locked) {
            session()->flash('error', 'Cette discussion est verrouillée.');
            return;
        }

        $this->thread->posts()->create([
            'user_id' => auth()->id(),
            'content' => $this->reply,
        ]);

        $this->thread->updatePostsCount();
        $this->thread->updateLastPost();

        $this->reply = '';
        session()->flash('success', 'Votre réponse a été ajoutée avec succès !');
    }

    public function render()
    {
        return view('livewire.pages.forum-thread-page', [
            'category' => $this->category,
            'thread' => $this->thread,
            'posts' => $this->thread->posts()->with('user')->orderBy('created_at', 'asc')->get(),
        ]);
    }
}
