<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumPost extends Model
{
    protected $fillable = [
        'forum_thread_id',
        'user_id',
        'parent_id',
        'content',
        'votes_count',
        'is_solution',
        'edited_at',
    ];

    protected $casts = [
        'is_solution' => 'boolean',
        'edited_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::created(function (ForumPost $post) {
            // Mettre à jour le compteur de posts du thread
            $post->thread->updatePostsCount();
            $post->thread->updateLastPost();
        });

        static::deleted(function (ForumPost $post) {
            // Mettre à jour le compteur de posts du thread
            $post->thread->updatePostsCount();
            $post->thread->updateLastPost();
        });
    }

    public function thread(): BelongsTo
    {
        return $this->belongsTo(ForumThread::class, 'forum_thread_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ForumPost::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ForumPost::class, 'parent_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(ForumPostVote::class);
    }

    public function upvotes(): HasMany
    {
        return $this->hasMany(ForumPostVote::class)->where('is_upvote', true);
    }

    public function downvotes(): HasMany
    {
        return $this->hasMany(ForumPostVote::class)->where('is_upvote', false);
    }

    public function updateVotesCount(): void
    {
        $upvotes = $this->upvotes()->count();
        $downvotes = $this->downvotes()->count();

        $this->update([
            'votes_count' => $upvotes - $downvotes
        ]);
    }

    public function getUserVoteAttribute(): ?ForumPostVote
    {
        if (!auth()->check()) {
            return null;
        }

        return $this->votes()->where('user_id', auth()->id())->first();
    }

    public function markAsSolution(): void
    {
        // Retirer la solution précédente dans ce thread
        $this->thread->posts()->where('is_solution', true)->update(['is_solution' => false]);

        // Marquer ce post comme solution
        $this->update(['is_solution' => true]);
    }

    public function markAsEdited(): void
    {
        $this->update(['edited_at' => now()]);
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeWithUser($query)
    {
        return $query->with('user');
    }
}