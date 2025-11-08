<?php

namespace App\Livewire\Pages\Gallery;

use App\Models\Event;
use Livewire\Component;

class AutoScrollEventImage extends Component
{
    public array $images = [];

    public function mount(): void
    {
        $this->images = [
            'images/event-2025/WhatsApp Image 2025-11-01 at 11.40.21 AM.jpeg',
            'images/event-2025/WhatsApp Image 2025-11-01 at 5.54.41 PM.jpeg',
            'images/event-2025/WhatsApp Image 2025-11-01 at 5.54.40 PM.jpeg',
            'images/event-2025/WhatsApp Image 2025-11-01 at 5.53.37 PM.jpeg',
            'images/event-2025/WhatsApp Image 2025-11-01 at 5.53.39 PM.jpeg',
            'images/event-2025/WhatsApp Image 2025-11-01 at 5.53.40 PM.jpeg',
            'images/event-2025/WhatsApp Image 2025-11-01 at 5.53.41 PM.jpeg',
            'images/event-2025/WhatsApp Image 2025-11-01 at 5.53.43 PM.jpeg',
            'images/event-2025/WhatsApp Image 2025-11-01 at 5.53.44 PM.jpeg',
            'images/event-2025/WhatsApp Image 2025-11-01 at 5.50.57 PM.jpeg',
            'images/event-2025/WhatsApp Image 2025-11-01 at 5.51.02 PM.jpeg',
            'images/event-2025/WhatsApp Image 2025-11-01 at 5.51.04 PM.jpeg',
            'images/event-2025/WhatsApp Image 2025-11-01 at 5.50.44 PM.jpeg',
            'images/event-2025/WhatsApp Image 2025-11-01 at 5.50.43 PM.jpeg',
            'images/event-2025/WhatsApp Image 2025-11-01 at 5.50.42 PM.jpeg',
        ];
    }

    public function render()
    {
        $events = Event::published()->count();

        return view('livewire.pages.gallery.auto-scroll-event-image', [
            'events' => $events,
        ]);
    }
}
