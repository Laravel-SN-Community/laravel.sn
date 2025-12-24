<?php

namespace App\Livewire\Pages;

use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Recap2025Page extends Component
{
    public array $images = [];

    public int $viewsCount = 0;

    public function mount(): void
    {
        $this->images = [
            ['src' => 'images/event-2025/laravelsn1.jpg', 'title' => 'Laravel Senegal Community'],
            ['src' => 'images/event-2025/dorogueye.png', 'title' => 'Doro Gueye, Presentation about Laravel Routing, Controllers, and Blade Templating,'],
            ['src' => 'images/event-2025/idrissawade.png', 'title' => 'Idrissa Wade, Presentation about Database migrations, seeding, Eloquent ORM and relationships'],
            ['src' => 'images/event-2025/diopsystem.png', 'title' => 'Diop System, Presentation about Middleware and request handling in Laravel'],
            ['src' => 'images/event-2025/ndogoucoding.png', 'title' => 'Ndogou Coding partenership between Laravel Senegal Community and Wommate'],
            ['src' => 'images/event-2025/follymessane.png', 'title' => 'Folly Messan, Presentation about Authentification & Autorisation in Laravel'],
            ['src' => 'images/event-2025/dorogueye1.png', 'title' => 'Doro Gueye, Presentation about the new laravel forge'],
            ['src' => 'images/event-2025/laravelevent.png', 'title' => 'The first PHP and Laravel events in Senegal'],
            ['src' => 'images/event-2025/WhatsApp Image 2025-11-01 at 5.51.04 PM.jpeg', 'title' => 'Laravel Community'],
            ['src' => 'images/event-2025/mouhamed.jpeg', 'title' => 'Mouhamed MBallo, Presentation about Filament'],
            ['src' => 'images/event-2025/ecran.jpeg', 'title' => 'Community Event'],
            ['src' => 'images/event-2025/WhatsApp Image 2025-11-01 at 11.40.21 AM.jpeg', 'title' => 'Ibrahima Diallo, Presentation about Laravel Starter Kit'],
            ['src' => 'images/event-2025/WhatsApp Image 2025-11-01 at 5.53.39 PM.jpeg', 'title' => 'Daouda, Presentation about Galsendev community'],
            ['src' => 'images/event-2025/adonai.jpeg', 'title' => 'Presentation Adonai Nangui'],
            ['src' => 'images/event-2025/WhatsApp Image 2025-11-01 at 5.51.02 PM.jpeg', 'title' => 'Developer Meetup'],
            ['src' => 'images/event-2025/galsendev.jpeg', 'title' => 'Galsendev, Keur Gou Makk'],
            ['src' => 'images/event-2025/teranga.jpeg', 'title' => 'Teranga coding'],
            ['src' => 'images/event-2025/WhatsApp Image 2025-11-01 at 5.53.43 PM.jpeg', 'title' => 'Laravel Senegal Event 2025'],
            ['src' => 'images/event-2025/WhatsApp Image 2025-11-01 at 5.53.44 PM.jpeg', 'title' => 'Community Celebration'],
            ['src' => 'images/event-2025/happynewyearvideo.mp4', 'title' => 'Happy New Year 2026'],
        ];

        $this->incrementViews();
        $this->viewsCount = $this->getViewsCount();
    }

    private function getViewsCount(): int
    {
        $filePath = 'recap_2025_views.json';

        if (Storage::disk('local')->exists($filePath)) {
            $data = json_decode(Storage::disk('local')->get($filePath), true);

            return $data['count'] ?? 0;
        }

        return 0;
    }

    private function incrementViews(): void
    {
        // Check if user has already viewed in this session
        if (session()->has('recap_2025_viewed')) {
            return;
        }

        $filePath = 'recap_2025_views.json';
        $count = $this->getViewsCount();
        $count++;

        Storage::disk('local')->put($filePath, json_encode([
            'count' => $count,
            'updated_at' => now()->toDateTimeString(),
        ]));

        // Mark as viewed in this session
        session()->put('recap_2025_viewed', true);
    }

    #[Layout('components.layouts.recap')]
    public function render()
    {
        return view('livewire.pages.recap-2025-page');
    }
}
