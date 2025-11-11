<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    /** @use HasFactory<\Database\Factories\LessonFactory> */
    use HasFactory;

    protected $fillable = [
        'chapter_id',
        'title',
        'slug',
        'content',
        'video_url',
        'duration',
        'position',
    ];

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }
}
