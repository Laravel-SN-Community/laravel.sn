@props(['user' => $user, 'span' => '-right-1 top-0 size-4 ring-2', 'container' => ''])

@if ($user->profile_photo_path)
    <img loading="lazy" {{ $attributes->merge(['class' => 'object-cover rounded-full bg-gray-100 dark:bg-gray-900']) }}
        src="{{ $user->profile_photo_path }}" alt="{{ $user->name }}" />
@else
    <div class="bg-yellow-600/40 p-1 rounded-full text-sm flex items-center justify-center">
        {{ $user->initials() }}
    </div>
@endif
