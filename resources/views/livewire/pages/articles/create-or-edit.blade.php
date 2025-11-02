<div class="min-h-full bg-gradient-to-br from-red-50 via-white to-green-50 ">

    <!-- Header Section -->
    <section class="py-4 bg-white border-b border-gray-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900">
                        {{ $isEditing ? 'Modifier l\'article' : 'Nouvel article' }}
                    </h1>
                    <p class="text-gray-600 mt-2">
                        {{ $isEditing ? 'Modifiez votre article' : 'Créez un nouvel article pour la communauté' }}
                    </p>
                </div>
                <x-filament::button
                    href="{{ route('articles.index') }}"
                    tag="a"
                    icon="heroicon-o-arrow-left-circle"
                    color="gray"
                 >
                    Retour
                </x-filament::button>
            </div>
        </div>
    </section>

    <!-- Form Section -->
    <section class="py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <form wire:submit="save">

                {{ $this->form }}

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-4 pt-6">
                    <x-filament::button tag="a" wire:navigate href="{{ route('articles.index') }}"
                       outlined="true"
                                        color="gray"
                    >
                        Annuler
                    </x-filament::button>
                    <x-filament::button
                        type="submit"
                        color="danger"
                        icon="heroicon-o-check"
                        wire:loading.attr="disabled"
                        wire:target="save">
                        <span wire:loading.remove wire:target="save">
                            {{ $isEditing ? 'Mettre à jour' : 'Créer l\'article' }}
                        </span>
                        <span wire:loading wire:target="save" class="inline-flex items-center">
                            {{ $isEditing ? 'Mise à jour...' : 'Création...' }}
                        </span>
                    </x-filament::button>
{{--                    <x-filament::button type="submit"--}}
{{--                            class=" bg-red-600 text-white rounded-lg hover:bg-red-700--}}
{{--                            transition-colors font-semibold flex items-center">--}}
{{--                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>--}}
{{--                        </svg>--}}
{{--                        {{ $isEditing ? 'Mettre à jour' : 'Créer l\'article' }}--}}
{{--                    </x-filament::button>--}}
                </div>

            </form>
        </div>
    </section>

    <x-filament-actions::modals />

</div>
