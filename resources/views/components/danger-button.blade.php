@php
    $classes =
        'inline-flex items-center justify-center py-2 px-4 border-0 text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-red-500';
@endphp

@if ($attributes->hasAny(['href', ':href']))
    <x-link :href="$href" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </x-link>
@else
    <button
        {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
        {{ $slot }}
    </button>
@endif
