<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ForumThread extends Model
{
    protected $fillable = [
        'forum_category_id',
        'user_id',
        'title',
        'slug',
        'content',
        'is_pinned',
        'is_locked',
        'views_count',
        'posts_count',
        'last_post_at',
        'last_post_user_id',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
        'last_post_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (ForumThread $thread) {
            if (empty($thread->slug)) {
                $thread->slug = Str::slug($thread->title);
            }
            $thread->last_post_at = now();
        });

        static::created(function (ForumThread $thread) {
            // Créer automatiquement le premier post avec le contenu du thread
            $thread->posts()->create([
                'user_id' => $thread->user_id,
                'content' => $thread->content,
            ]);
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ForumCategory::class, 'forum_category_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lastPostUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_post_user_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(ForumPost::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(ForumSubscription::class);
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function updatePostsCount(): void
    {
        $this->update([
            'posts_count' => $this->posts()->count()
        ]);
    }

    public function updateLastPost(): void
    {
        $lastPost = $this->posts()->with('user')->latest()->first();

        if ($lastPost) {
            $this->update([
                'last_post_at' => $lastPost->created_at,
                'last_post_user_id' => $lastPost->user_id,
            ]);
        }
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeNotLocked($query)
    {
        return $query->where('is_locked', false);
    }
}