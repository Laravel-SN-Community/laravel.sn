<?php

namespace App\Livewire\Pages;

use Livewire\Attributes\Layout;
use Livewire\Component;

class DashboardPage extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.dashboard-page');
    }
}
