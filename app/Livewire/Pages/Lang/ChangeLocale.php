<?php

namespace App\Livewire\Pages\Lang;

use Livewire\Attributes\Computed;
use Livewire\Component;

final class ChangeLocale extends Component
{
    public ?string $currentLocale = null;

    public function mount(): void
    {
        $this->currentLocale = app()->getLocale();
    }

    public function setLocale(string $locale): void
    {
        $supportedLocales = config('app.available_locales', ['en', 'fr']);

        if (! in_array($locale, $supportedLocales)) {
            return;
        }

        $this->currentLocale = $locale;
        app()->setLocale($locale);
        session()->put('locale', $locale);

        $this->redirect(url()->previous(), navigate: true);
    }

    #[Computed]
    public function currentLocaleName(): string
    {
        return $this->getLocaleName($this->currentLocale);
    }

    #[Computed]
    public function availableLocales(): array
    {
        $locales = config('app.available_locales', ['en', 'fr']);

        return array_map(function ($locale) {
            return [
                'code' => $locale,
                'name' => $this->getLocaleName($locale),
            ];
        }, $locales);
    }

    protected function getLocaleName(string $locale): string
    {
        return match ($locale) {
            'en' => 'English',
            'fr' => 'Français',
            default => $locale,
        };
    }

    public function render()
    {
        return view('livewire.pages.lang.change-locale');
    }
}
