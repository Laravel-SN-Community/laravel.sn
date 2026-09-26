<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

final readonly class AssignUserRole
{
    /**
     * Replace the user's role. A user carries exactly one role, so the
     * previous one is always dropped.
     *
     * @throws ValidationException when the change would leave no admin behind
     */
    public function __invoke(User $user, string $role): User
    {
        if ($user->isAdmin() && $role !== 'admin' && $this->isLastAdmin($user)) {
            throw ValidationException::withMessages([
                'role' => "Impossible de rétrograder le dernier administrateur. Nommez d'abord un autre administrateur.",
            ]);
        }

        $user->syncRoles([Role::findByName($role)]);

        return $user->refresh();
    }

    private function isLastAdmin(User $user): bool
    {
        return User::query()
            ->role('admin')
            ->whereKeyNot($user->getKey())
            ->doesntExist();
    }
}
