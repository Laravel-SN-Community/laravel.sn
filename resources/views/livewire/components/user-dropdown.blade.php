<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

@php
    $user = \Illuminate\Support\Facades\Auth::user();
@endphp

<div>
    <x-dropdown align="right" width="48">
        <x-slot name="trigger">
            <x-user.avatar :user="$user" class="size-8" />
        </x-slot>
        <x-slot name="content">
            <div class="px-3.5 py-3 border-b">
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    {{ __('global.signed_as') }}
                </p>
                <p class="truncate text-sm font-medium text-gray-900">
                    {{ $user->email }}
                </p>
            </div>
            <div class="flex flex-col space-y-2 p-4">
                <x-link :href="route('profile.show')" class="group flex items-center gap-2 text-sm text-gray-400 dark:text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-circle-user-icon lucide-circle-user size-4">
                        <circle cx="12" cy="12" r="10" />
                        <circle cx="12" cy="10" r="3" />
                        <path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662" />
                    </svg>
                    {{ __('global.navigation.profile') }}
                </x-link>
                <livewire:components.logout />
            </div>
        </x-slot>
    </x-dropdown>
</div>
