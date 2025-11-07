<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForumPostVote extends Model
{
    protected $fillable = [
        'forum_post_id',
        'user_id',
        'is_upvote',
    ];

    protected $casts = [
        'is_upvote' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::created(function (ForumPostVote $vote) {
            $vote->post->updateVotesCount();
        });

        static::updated(function (ForumPostVote $vote) {
            $vote->post->updateVotesCount();
        });

        static::deleted(function (ForumPostVote $vote) {
            $vote->post->updateVotesCount();
        });
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(ForumPost::class, 'forum_post_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}