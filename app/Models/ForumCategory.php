<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ForumCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (ForumCategory $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function threads(): HasMany
    {
        return $this->hasMany(ForumThread::class);
    }

    public function getThreadsCountAttribute(): int
    {
        return $this->threads()->count();
    }

    public function getPostsCountAttribute(): int
    {
        return ForumPost::whereHas('thread', function ($query) {
            $query->where('forum_category_id', $this->id);
        })->count();
    }

    public function getLatestThreadAttribute(): ?ForumThread
    {
        return $this->threads()
            ->with('user')
            ->latest('last_post_at')
            ->first();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
