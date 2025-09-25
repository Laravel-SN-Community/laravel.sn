<?php

namespace Tests\Feature\Livewire\Pages;

use App\Enums\SubscriberStatus;
use App\Livewire\Pages\WelcomePage;
use Livewire\Livewire;

it('can render the welcome page', function () {
    $response = $this->get('/')
        ->assertSeeLivewire(WelcomePage::class)
        ->assertStatus(200);
});

it('can subscribe to the newsletter', function () {
    $email = fake()->email();

    Livewire::test(WelcomePage::class)
        ->set('email', $email)
        ->call('subscribe')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('newsletter_subscriptions', [
        'email' => $email,
        'status' => SubscriberStatus::Subscribed,
    ]);
});
