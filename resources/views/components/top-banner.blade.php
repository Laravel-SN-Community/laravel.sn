@php
    use Carbon\Carbon;
    Carbon::setLocale('fr');
@endphp

@props(['ongoingEvent' => []])

<div>
    <a href="{{ route('event.show', $ongoingEvent->id) }}"
        class="relative isolate flex items-center gap-x-6 overflow-hidden bg-red-600 px-6 py-3 sm:px-3.5 sm:before:flex-1 cursor-pointer hover:opacity-60 transition text-white">
        <div class="flex flex-wrap items-center gap-x-1 gap-y-2 text-slide sm:hidden">
            <p class="text-lg leading-6 overflow-x-auto text-nowrap ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" aria-hidden="true" class="mr-2 hidden h-6 w-6 lg:inline">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                    </path>
                </svg>
                <strong class="font-semibold">{{ $ongoingEvent->name ?? '' }}</strong>
                {{ Carbon::parse($ongoingEvent->date ?? '')->translatedFormat('d F Y') }}
                <strong class="mx-3">&rarr;</strong>
            </p>
        </div>

        <div class="hidden sm:flex flex-wrap items-center gap-x-1 gap-y-2">
            <p class="text-lg leading-6 overflow-x-hidden text-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" aria-hidden="true" class="mr-2 hidden h-6 w-6 lg:inline">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                    </path>
                </svg>
                <strong class="font-semibold">{{ $ongoingEvent->name ?? '' }}</strong>,
                {{ Carbon::parse($ongoingEvent->date ?? '')->translatedFormat('d F Y') }}
                <strong class="mx-3">&rarr;</strong>
            </p>
        </div>
        <div class="flex flex-1 justify-end"></div>
    </a>
</div>
