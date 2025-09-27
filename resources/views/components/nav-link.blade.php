@props(['active', 'title' => '', 'href' => '#'])

@php
    $classes = $active ?? false ? 'text-green-600' : 'text-gray-500 transition hover:text-gray-500/75 text-sm font-semibold';
@endphp

<x-link :href="$href" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $title }}
</x-link>
