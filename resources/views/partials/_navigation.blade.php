<a href="{{ route('welcome') }}" wire:navigate
    class="{{ request()->routeIs('welcome') ? 'text-red-600 font-bold' : 'text-gray-900 font-bold hover:text-red-600 transition-colors' }}">{{ __('Accueil') }}</a>
<a href="{{ route('events') }}" wire:navigate
    class="{{ request()->routeIs('events') ? 'text-red-600 font-bold' : 'text-gray-900 font-bold hover:text-red-600 transition-colors' }}">{{ __('Événements') }}</a>
<a href="{{ route('articles') }}" wire:navigate
    class="{{ request()->routeIs('articles') ? 'text-red-600 font-bold' : 'text-gray-900 font-bold hover:text-red-600 transition-colors' }}">{{ __('Articles') }}</a>
