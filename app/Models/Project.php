<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use CyrildeWit\EloquentViewable\Contracts\Viewable as ViewableContract;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Tags\HasTags;

class Project extends Model implements HasMedia, ViewableContract
{
    use HasFactory;
    use HasTags;
    use InteractsWithMedia;
    use InteractsWithViews;

    protected $fillable = ['name', 'slug', 'description', 'github_link', 'project_link', 'status', 'user_id', 'cover'];

    protected function casts(): array
    {
        return [
            'status' => ProjectStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the categories for the project.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Get the votes for the project.
     */
    public function votes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'votes')
            ->withTimestamps();
    }

    /**
     * Get the voters for the project.
     */
    public function voters(): BelongsToMany
    {
        return $this->votes();
    }

    /**
     * Get the count of votes for the project.
     */
    public function votesCount(): int
    {
        return $this->votes()->count();
    }

    /**
     * Get a truncated description of the project (50 characters).
     */
    protected function shortDescription(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::limit($this->description, 100)
        );
    }

    /**
     * Register the media collections for the project.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('projects')
            ->useDisk('public')
            ->singleFile();
    }

}
