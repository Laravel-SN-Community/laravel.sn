<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PublicationStatus;
use Carbon\CarbonInterface;
use Database\Factories\ArticleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Override;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property PublicationStatus $status
 * @property Carbon|null $published_at
 * @property Carbon|null $content_updated_at
 * @property Carbon|null $submitted_at
 * @property Carbon|null $approved_at
 * @property Carbon|null $declined_at
 * @property bool $is_featured
 * @property int $reading_time_minutes
 * @property int $views_count
 * @property int $likes_count
 * @property array<string, mixed>|null $seo_meta
 * @property string $excerpt
 * @property bool $was_revised
 * @property string|null $cover_url
 * @property array{sm?: string, md?: string, full?: string}|null $cover_srcset
 */
#[Fillable([
    'author_id',
    'title',
    'slug',
    'body',
    'locale',
    'status',
    'published_at',
    'content_updated_at',
    'submitted_at',
    'approved_at',
    'declined_at',
    'reading_time_minutes',
    'is_featured',
    'seo_meta',
])]
final class Article extends Model implements HasMedia
{
    /** @use HasFactory<ArticleFactory> */
    use HasFactory;

    use InteractsWithMedia;
    use Searchable;
    use SoftDeletes;

    /** @var list<string> */
    protected $appends = ['excerpt', 'cover_url', 'cover_srcset', 'was_revised'];

    #[Override]
    protected static function boot(): void
    {
        parent::boot();

        self::creating(function (self $article): void {
            if (empty($article->slug)) {
                $base = Str::slug($article->title);
                $slug = $base;
                $count = 1;

                while (self::withTrashed()->where('slug', $slug)->exists()) {
                    $slug = "{$base}-{$count}";
                    $count++;
                }

                $article->slug = $slug;
            }
        });
    }

    /**
     * @return array<string, string>
     */
    #[Override]
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'content_updated_at' => 'datetime',
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
            'declined_at' => 'datetime',
            'is_featured' => 'boolean',
            'reading_time_minutes' => 'integer',
            'views_count' => 'integer',
            'likes_count' => 'integer',
            'status' => PublicationStatus::class,
            'seo_meta' => 'array',
        ];
    }

    /** @return BelongsTo<User, $this> */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where('status', PublicationStatus::Published)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    #[Scope]
    protected function featured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    #[Scope]
    protected function inLocale(Builder $query, string $locale): void
    {
        $query->where('locale', $locale);
    }

    #[Scope]
    protected function withTag(Builder $query, string $tagSlug): void
    {
        $query->whereHas('tags', fn (Builder $q) => $q->where('slug', $tagSlug));
    }

    protected function excerpt(): Attribute
    {
        return Attribute::get(function (): string {
            $text = preg_replace('/```[\s\S]*?```/', '', $this->body ?? '');
            $text = preg_replace('/[#*`\[\]_>~]/', '', $text ?? '');
            $text = trim(preg_replace('/\s+/', ' ', $text ?? ''));

            return mb_strlen($text) > 200 ? mb_substr($text, 0, 200).'…' : $text;
        });
    }

    /**
     * Whether the body was actually edited after the article went live.
     *
     * Two conditions, because published_at is a date picked by the author and
     * therefore sits at midnight, while content_updated_at is a real instant.
     * Comparing only those two marks every article published on the day it
     * was written as revised, by however many hours past midnight it happened
     * to be written. So an edit must also have moved content_updated_at away
     * from created_at, which CreateArticle stamps them level at.
     */
    protected function wasRevised(): Attribute
    {
        return Attribute::get(function (): bool {
            // CarbonInterface, not Carbon: Date::use(CarbonImmutable::class)
            // means these casts hydrate to CarbonImmutable, which does not
            // extend Carbon\Carbon.
            if (! $this->published_at instanceof CarbonInterface || ! $this->content_updated_at instanceof CarbonInterface) {
                return false;
            }

            if (! $this->created_at instanceof CarbonInterface) {
                return false;
            }

            // A few seconds of slack: both columns are written by the same
            // insert and can straddle a second boundary.
            $editedSinceCreation = $this->content_updated_at->diffInSeconds($this->created_at, true) > 5;

            return $editedSinceCreation
                && $this->content_updated_at->greaterThan($this->published_at);
        });
    }

    protected function coverUrl(): Attribute
    {
        return Attribute::get(function (): ?string {
            $url = $this->getCoverImageUrl();

            return $url !== '' ? $url : null;
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('media')
            ->singleFile()
            ->acceptsMimeTypes([
                'image/jpg',
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/avif',
            ]);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->performOnCollections('media')
            ->format('webp')
            ->quality(85);

        $this->addMediaConversion('webp_md')
            ->performOnCollections('media')
            ->format('webp')
            ->width(1280)
            ->quality(82);

        $this->addMediaConversion('webp_sm')
            ->performOnCollections('media')
            ->format('webp')
            ->width(640)
            ->quality(80);
    }

    public function getCoverImageUrl(): string
    {
        $media = $this->getFirstMedia('media');

        if (! $media instanceof Media) {
            return '';
        }

        if ($media->hasGeneratedConversion('webp')) {
            return $media->getUrl('webp');
        }

        return $media->getUrl();
    }

    protected function coverSrcset(): Attribute
    {
        return Attribute::get(function (): ?array {
            $media = $this->getFirstMedia('media');

            if (! $media instanceof Media) {
                return null;
            }

            $sm = $media->hasGeneratedConversion('webp_sm') ? $media->getUrl('webp_sm') : null;
            $md = $media->hasGeneratedConversion('webp_md') ? $media->getUrl('webp_md') : null;
            $full = $media->hasGeneratedConversion('webp') ? $media->getUrl('webp') : $media->getUrl();

            if ($sm === null && $md === null) {
                return null;
            }

            return [
                'sm' => $sm,
                'md' => $md,
                'full' => $full,
            ];
        });
    }

    protected function url(): Attribute
    {
        return Attribute::get(fn (): string => route('article', $this->slug));
    }

    #[Override]
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function isPublished(): bool
    {
        return $this->status === PublicationStatus::Published
            && $this->published_at !== null
            && $this->published_at->isPast();
    }

    public function shouldBeSearchable(): bool
    {
        return $this->isPublished();
    }

    /**
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        $this->loadMissing('author', 'tags');

        return [
            'id' => (string) $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'author' => $this->author->name,
            'tags' => $this->tags->pluck('name')->all(),
            'published_at' => $this->published_at->timestamp,
        ];
    }
}
