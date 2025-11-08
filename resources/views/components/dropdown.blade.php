@props([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white',
    'dropdownClasses' => ''
])

@php
    $align = strtolower(trim($align));

    $origin = '';
    $position = '';
    $margin = 'mt-2'; // default downward

    switch ($align) {
        // ── Top row (opens upward) ──
        case 'top-left':
        case 'top_left':
        case 'topleft':
            $origin   = 'ltr:origin-bottom-left rtl:origin-bottom-right';
            $position = 'left-0 bottom-full mb-2';
            break;

        case 'top':
        case 'top-center':
        case 'top_center':
            $origin   = 'origin-bottom';
            $position = 'left-1/2 -translate-x-1/2 bottom-full mb-2';
            break;

        case 'top-right':
        case 'top_right':
        case 'topright':
            $origin   = 'ltr:origin-bottom-right rtl:origin-bottom-left';
            $position = 'right-0 bottom-full mb-2';
            break;

        // ── Middle row ──
        case 'left':
            $origin   = 'ltr:origin-top-left rtl:origin-top-right';
            $position = 'left-0 top-1/2 -translate-y-1/2';
            $margin   = '';
            break;

        case 'right':
        case '': // default
            $origin   = 'ltr:origin-top-right rtl:origin-top-left';
            $position = 'right-0 top-0';
            break;

        // ── Bottom row (default direction) ──
        case 'bottom-left':
        case 'bottom_left':
        case 'bottomleft':
            $origin   = 'ltr:origin-top-left rtl:origin-top-right';
            $position = 'left-0';
            break;

        case 'bottom':
        case 'bottom-center':
        case 'bottom_center':
            $origin   = 'origin-top';
            $position = 'left-1/2 -translate-x-1/2';
            break;

        case 'bottom-right':
        case 'bottom_right':
        case 'bottomright':
            $origin   = 'ltr:origin-top-right rtl:origin-top-left';
            $position = 'right-0';
            break;

        // ── Disable auto-positioning ──
        case 'none':
        case 'false':
        case '0':
        case false:
            $origin = $position = $margin = '';
            break;

        // ── Fallback (original default) ──
        default:
            $origin   = 'ltr:origin-top-right rtl:origin-top-left';
            $position = 'right-0';
            break;
    }

    $widthClass = match ($width) {
        '48' => 'w-48',
        '60' => 'w-60',
        '80' => 'w-80',
        default => is_numeric($width) ? "w-{$width}" : $width,
    };
@endphp

<div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute z-50 {{ $margin }} {{ $widthClass }} rounded-md shadow-lg {{ $origin }} {{ $position }} {{ $dropdownClasses }}"
        style="display: none;"
        @click="open = false"
    >
        <div class="rounded-md ring-1 ring-gray-100 ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>