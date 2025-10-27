<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use CyrildeWit\EloquentViewable\Contracts\Viewable as ViewableContract;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use League\CommonMark\CommonMarkConverter;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia, ViewableContract
{
    use HasFactory;
    use InteractsWithMedia;
    use InteractsWithViews;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'description',
        'github_url',
        'demo_url',
        'status',
        'votes_count',
        'average_rating',
        'rejection_reason',
        'approved_at',
    ];

    protected $casts = [
        'status' => ProjectStatus::class,
        'approved_at' => 'datetime',
        'votes_count' => 'integer',
        'average_rating' => 'decimal:2',
    ];

    /**
     * Get the user that owns the project.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category of the project.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the votes for the project.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(ProjectVote::class);
    }

    /**
     * Get the reviews for the project.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(ProjectReview::class);
    }

    /**
     * Scope a query to only include approved projects.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', ProjectStatus::Approved);
    }

    /**
     * Scope a query to only include pending projects.
     */
    public function scopePending($query)
    {
        return $query->where('status', ProjectStatus::Pending);
    }

    /**
     * Scope a query to only include rejected projects.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', ProjectStatus::Rejected);
    }

    /**
     * Get the project description as HTML (parsed from markdown).
     */
    protected function descriptionHtml(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                $converter = new CommonMarkConverter([
                    'html_input' => 'strip',
                    'allow_unsafe_links' => false,
                    'max_nesting_level' => 10,
                ]);

                $html = $converter->convert($this->description)->getContent();

                // Add Prism.js classes to code blocks for syntax highlighting
                $html = preg_replace(
                    '/<pre><code class="language-([^"]+)">/',
                    '<pre class="language-$1"><code class="language-$1">',
                    $html
                );

                // Handle code blocks without language specification
                $html = preg_replace(
                    '/<pre><code>/',
                    '<pre class="language-text"><code class="language-text">',
                    $html
                );

                return $html;
            }
        );
    }

    /**
     * Get a plain text excerpt of the project description.
     */
    protected function excerpt(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                // Strip markdown syntax and get first 150 characters
                $plainText = strip_tags($this->description_html);

                return Str::limit($plainText, 150);
            }
        );
    }

    /**
     * Check if the user has voted for this project.
     */
    public function hasVotedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->votes()->where('user_id', $user->id)->exists();
    }

    /**
     * Check if the user has reviewed this project.
     */
    public function hasReviewedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->reviews()->where('user_id', $user->id)->exists();
    }
}
