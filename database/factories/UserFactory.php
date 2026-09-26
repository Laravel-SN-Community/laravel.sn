<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->regexify('[a-z][a-z0-9_]{4,15}'),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes): array => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->afterCreating(function (User $user): void {
            $user->assignRole(Role::firstOrCreate(['name' => 'admin']));
        });
    }

    public function moderator(): static
    {
        return $this->afterCreating(function (User $user): void {
            $user->assignRole(Role::firstOrCreate(['name' => 'moderator']));
        });
    }

    public function asUser(): static
    {
        return $this->afterCreating(function (User $user): void {
            $user->assignRole(Role::firstOrCreate(['name' => 'user']));

            if (! app()->runningUnitTests()) {
                $user->addMediaFromUrl("https://i.pravatar.cc/150?u={$user->username}")
                    ->toMediaCollection('avatar');
            }
        });
    }

    /**
     * Indicate that the account is permanently suspended.
     */
    public function suspended(): static
    {
        return $this->state(fn (array $attributes): array => [
            'suspended_at' => now(),
            'suspended_until' => null,
            'suspension_reason' => 'Non-respect du code de conduite.',
        ]);
    }

    /**
     * Indicate that the account is suspended until a given moment.
     * A past $until produces an expired suspension.
     */
    public function suspendedUntil(CarbonInterface $until): static
    {
        return $this->state(fn (array $attributes): array => [
            'suspended_at' => now(),
            'suspended_until' => $until,
            'suspension_reason' => 'Non-respect du code de conduite.',
        ]);
    }

    /**
     * Indicate that the model has two-factor authentication configured.
     */
    public function withTwoFactor(): static
    {
        return $this->state(fn (array $attributes): array => [
            'two_factor_secret' => encrypt('secret'),
            'two_factor_recovery_codes' => encrypt(json_encode(['recovery-code-1'])),
            'two_factor_confirmed_at' => now(),
        ]);
    }
}
