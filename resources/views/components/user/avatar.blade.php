@props(['user' => $user, 'span' => '-right-1 top-0 size-4 ring-2', 'container' => ''])

@if ($user->profile_photo_path)
    <img loading="lazy" {{ $attributes->merge(['class' => 'object-cover rounded-full bg-gray-100 dark:bg-gray-900']) }}
        src="{{ $user->profile_photo_path }}" alt="{{ $user->name }}" />
@else
    <div class="bg-red-600/70 text-white p-2 rounded-full flex items-center justify-center cursor-pointer">
        {{ $user->initials() }}
    </div>
@endif