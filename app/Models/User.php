<?php

declare(strict_types=1);

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Carbon\CarbonInterface;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Scout\Searchable;
use Override;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property-read string|null $avatar
 * @property CarbonInterface|null $email_verified_at
 * @property CarbonInterface|null $last_active_at
 * @property CarbonInterface|null $suspended_at
 * @property CarbonInterface|null $suspended_until
 * @property string|null $suspension_reason
 * @property int|null $suspended_by_id
 */
#[Fillable(['name', 'username', 'email', 'password', 'bio', 'location', 'github_handle', 'twitter_handle', 'linkedin_handle', 'website_url'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token', 'github_id', 'google_id', 'suspension_reason', 'suspended_by_id'])]

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use HasRoles;
    use InteractsWithMedia;
    use Notifiable;
    use Searchable;
    use TwoFactorAuthenticatable;

    /** @var list<string> */
    protected $appends = ['avatar'];

    protected function avatar(): Attribute
    {
        return Attribute::get(function (): ?string {
            $media = $this->getFirstMedia('avatar');

            if (! $media instanceof Media) {
                return null;
            }

            return $media->hasGeneratedConversion('webp')
                ? $media->getUrl('webp')
                : $media->getUrl();
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
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
            ->performOnCollections('avatar')
            ->format('webp')
            ->quality(85);
    }

    #[Override]
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    #[Override]
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isModerator(): bool
    {
        return $this->hasRole(['admin', 'moderator']);
    }

    /**
     * A suspension stays active until a moderator lifts it, or until
     * suspended_until passes. A null suspended_until means permanent.
     */
    public function isSuspended(): bool
    {
        if (! $this->suspended_at instanceof CarbonInterface) {
            return false;
        }

        return ! $this->suspended_until instanceof CarbonInterface
            || $this->suspended_until->isFuture();
    }

    /**
     * Tell a locked-out member when the suspension ends and who to write to.
     * The stored reason is deliberately left out: it is moderator-facing
     * context, not something to hand back at the login screen.
     */
    public function suspensionMessage(): ?string
    {
        if (! $this->isSuspended()) {
            return null;
        }

        $until = $this->suspended_until;

        $window = $until instanceof CarbonInterface
            ? "Votre compte est suspendu jusqu'au {$until->locale((string) config('app.locale'))->isoFormat('D MMMM YYYY')}."
            : 'Votre compte a été suspendu.';

        return "{$window} Si vous pensez qu'il s'agit d'une erreur, écrivez-nous à contact@laravel.sn.";
    }

    /**
     * @return BelongsTo<self, $this>
     */
    public function suspendedBy(): BelongsTo
    {
        return $this->belongsTo(self::class, 'suspended_by_id');
    }

    /**
     * @param  Builder<self>  $query
     */
    public function scopeSuspended(Builder $query): void
    {
        $query->whereNotNull('suspended_at')
            ->where(fn (Builder $sub) => $sub
                ->whereNull('suspended_until')
                ->orWhere('suspended_until', '>', now())
            );
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    #[Override]
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_active_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
            'settings' => 'array',
            'suspended_at' => 'datetime',
            'suspended_until' => 'datetime',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => (string) $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'bio' => $this->bio,
            'location' => $this->location,
        ];
    }
}
