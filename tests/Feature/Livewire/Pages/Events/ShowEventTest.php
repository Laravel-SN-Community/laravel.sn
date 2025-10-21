<?php

namespace Tests\Feature\Livewire\Pages\Events;

use App\Livewire\Pages\Events\Show;
use App\Models\Event;
use Livewire\Livewire;

it('can render the event show page', function () {
    $event = Event::factory()->create([
        'is_published' => true,
    ]);

    $response = $this->get(route('event.show', $event))
        ->assertSeeLivewire(Show::class)
        ->assertStatus(200);
});

it('displays event details correctly', function () {
    $event = Event::factory()->create([
        'name' => 'Laravel Conference 2025',
        'place' => 'Dakar, Senegal',
        'description' => 'An amazing Laravel conference',
        'is_published' => true,
    ]);

    Livewire::test(Show::class, ['event' => $event])
        ->assertSee('Laravel Conference 2025')
        ->assertSee('Dakar, Senegal')
        ->assertSee('An amazing Laravel conference');
});

it('shows rsvp link when available', function () {
    $event = Event::factory()->create([
        'rsvp_link' => 'https://example.com/rsvp',
        'is_published' => true,
    ]);

    Livewire::test(Show::class, ['event' => $event])
        ->assertSee('https://example.com/rsvp');
});

it('shows event link when available', function () {
    $event = Event::factory()->create([
        'event_link' => 'https://example.com/event',
        'is_published' => true,
    ]);

    Livewire::test(Show::class, ['event' => $event])
        ->assertSee('https://example.com/event');
});

it('returns 404 for unpublished events', function () {
    $event = Event::factory()->create([
        'is_published' => false,
    ]);

    $this->get(route('event.show', $event))
        ->assertNotFound();
});

it('displays the correct formatted date', function () {
    $event = Event::factory()->create([
        'date' => '2025-12-25 18:00:00',
        'is_published' => true,
    ]);

    $response = $this->get(route('event.show', $event));

    $response->assertSee('18:00');
});
