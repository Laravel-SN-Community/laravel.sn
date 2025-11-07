<?php

namespace App\Livewire\Pages\Events;

use App\Models\Event;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public Event $event;

    public function mount(Event $event): void
    {
        // Only allow published events to be viewed
        if (! $event->is_published) {
            abort(404);
        }

        $this->event = $event;
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.pages.events.show');
    }
}
