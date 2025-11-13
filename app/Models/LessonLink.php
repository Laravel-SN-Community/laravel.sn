<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonLink extends Model
{
    /** @use HasFactory<\Database\Factories\LessonLinkFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'lesson_id',
    ];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
