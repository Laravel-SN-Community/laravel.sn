<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectVote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
    ];

    /**
     * Get the user that owns the vote.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the project that owns the vote.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
