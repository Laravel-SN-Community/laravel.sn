<?php

use App\Enums\UserRole;
use App\Filament\Resources\Technologies\Pages\CreateTechnology;
use App\Models\Technology;
use App\Models\User;
use Filament\Facades\Filament;
use Livewire\Livewire;

it('allows admin to create a technology', function () {
    Filament::setCurrentPanel('admin');

    $admin = User::factory()->create([
        'role' => UserRole::ADMIN,
    ]);

    $this->actingAs($admin);

    Livewire::test(CreateTechnology::class)
        ->fillForm([
            'name' => 'Laravel',
            'slug' => 'laravel',
        ])
        ->call('create')
        ->assertNotified()
        ->assertRedirect();

    expect(Technology::query()->where('slug', 'laravel')->exists())->toBeTrue();
});
