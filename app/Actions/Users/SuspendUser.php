<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Validation\ValidationException;

final readonly class SuspendUser
{
    /**
     * Suspend an account. A null $durationDays makes the suspension
     * permanent until a moderator lifts it.
     *
     * @throws ValidationException when the target may not be suspended
     */
    public function __invoke(User $user, User $moderator, string $reason, ?int $durationDays = null): User
    {
        if ($user->is($moderator)) {
            throw ValidationException::withMessages([
                'reason' => 'Vous ne pouvez pas suspendre votre propre compte.',
            ]);
        }

        if ($user->isAdmin()) {
            throw ValidationException::withMessages([
                'reason' => 'Un administrateur ne peut pas être suspendu.',
            ]);
        }

        // Only rank outranking the target may suspend it, so one moderator
        // cannot disable a peer — and by extension the moderation team.
        if ($user->isModerator() && ! $moderator->isAdmin()) {
            throw ValidationException::withMessages([
                'reason' => "Seul un administrateur peut suspendre un membre de l'équipe de modération.",
            ]);
        }

        // forceFill: the suspension columns are deliberately left out of the
        // model's fillable list so they can never be set from user input.
        $user->forceFill([
            'suspended_at' => now(),
            'suspended_until' => $durationDays === null ? null : now()->addDays($durationDays),
            'suspension_reason' => $reason,
            'suspended_by_id' => $moderator->getKey(),
        ])->save();

        return $user->refresh();
    }
}
