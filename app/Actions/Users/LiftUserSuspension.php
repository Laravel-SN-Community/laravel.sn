<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Validation\ValidationException;

final readonly class LiftUserSuspension
{
    /**
     * @throws ValidationException when the actor is outranked by the target
     */
    public function __invoke(User $user, User $moderator): User
    {
        // Mirrors SuspendUser: a moderator who cannot suspend a peer must
        // not be able to undo an admin's decision about one either.
        if ($user->isModerator() && ! $moderator->isAdmin()) {
            throw ValidationException::withMessages([
                'user' => "Seul un administrateur peut lever la suspension d'un membre de l'équipe de modération.",
            ]);
        }

        // forceFill: the suspension columns are deliberately left out of the
        // model's fillable list so they can never be set from user input.
        $user->forceFill([
            'suspended_at' => null,
            'suspended_until' => null,
            'suspension_reason' => null,
            'suspended_by_id' => null,
        ])->save();

        return $user->refresh();
    }
}
