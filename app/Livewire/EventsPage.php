<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class EventsPage extends Component
{
    use WithPagination;

    public string $search = '';

    public string $filter = 'all';

    public function mount()
    {
        $this->filter = 'all';
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        $events = Event::query()
            ->published()
            ->when($this->filter === 'upcoming', fn ($query) => $query->upcoming())
            ->when($this->filter === 'past', fn ($query) => $query->past())
            ->when($this->search, fn ($query) => $query->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('place', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%');
            }))
            ->orderBy('date', 'desc')
            ->paginate(5);

        return view('livewire.events-page', [
            'events' => $events,
        ]);
    }
}
