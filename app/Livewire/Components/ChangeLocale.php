<?php

namespace App\Livewire\Components;

use Livewire\Attributes\Computed;
use Livewire\Component;

final class ChangeLocale extends Component
{
    public ?string $currentLocale = null;

    public function changeLocale()
    {
        $locale = $this->currentLocale === 'fr' ? 'en' : 'fr';

        $this->currentLocale = $locale;
        app()->setLocale($locale);
        session()->put('locale', $locale);

        $this->redirect(url()->previous(), navigate: true);
    }

    public function mount()
    {
        $this->currentLocale = app()->getLocale();
    }

    #[Computed]
    public function locale(): string
    {
        return $this->currentLocale === 'fr' ? 'English' : 'Français';
    }

    public function render()
    {
        return view('livewire.components.change-locale');
    }
}
