<div class="space-y-6" x-data="{
    images: @js($images),
    modalOpen: false,
    modalImage: '',
    init() {
        this.$watch('modalOpen', value => {
            if (value) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });
    },
    openModal(image) {
        this.modalImage = image;
        this.modalOpen = true;
    },
    closeModal() {
        this.modalOpen = false;
        this.modalImage = '';
    }
}">

    <!-- Auto-Scrolling Image Rows -->
    <div class="space-y-4">
        <!-- First Row - Scrolls Left to Right -->
        <div class="relative overflow-hidden rounded-xl">
            <div class="flex gap-4 animate-scroll-right" style="width: max-content;">
                <!-- Original images -->
                <template x-for="(image, index) in images.slice(0, Math.ceil(images.length / 2))" :key="'row1-' + index">
                    <div class="group relative cursor-pointer overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 hover:scale-105 flex-shrink-0 w-80"
                        @click="openModal('{{ asset('') }}' + image)">
                        <div class="aspect-[4/3] bg-gradient-to-br from-red-100 to-green-100">
                            <img :src="'{{ asset('') }}' + image"
                                :alt="'Laravel Senegal Event ' + (index + 1)"
                                class="w-full h-full object-cover"
                                loading="lazy">
                        </div>
                        <!-- Hover overlay -->
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                    </div>
                </template>
                <!-- Duplicate for seamless loop -->
                <template x-for="(image, index) in images.slice(0, Math.ceil(images.length / 2))" :key="'row1-dup-' + index">
                    <div class="group relative cursor-pointer overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 hover:scale-105 flex-shrink-0 w-80"
                        @click="openModal('{{ asset('') }}' + image)">
                        <div class="aspect-[4/3] bg-gradient-to-br from-red-100 to-green-100">
                            <img :src="'{{ asset('') }}' + image"
                                :alt="'Laravel Senegal Event ' + (index + 1)"
                                class="w-full h-full object-cover"
                                loading="lazy">
                        </div>
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Second Row - Scrolls Right to Left -->
        <div class="relative overflow-hidden rounded-xl">
            <div class="flex gap-4 animate-scroll-left" style="width: max-content;">
                <!-- Original images -->
                <template x-for="(image, index) in images.slice(Math.ceil(images.length / 2))" :key="'row2-' + index">
                    <div class="group relative cursor-pointer overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 hover:scale-105 flex-shrink-0 w-80"
                        @click="openModal('{{ asset('') }}' + image)">
                        <div class="aspect-[4/3] bg-gradient-to-br from-red-100 to-green-100">
                            <img :src="'{{ asset('') }}' + image"
                                :alt="'Laravel Senegal Event ' + (index + Math.ceil(images.length / 2) + 1)"
                                class="w-full h-full object-cover"
                                loading="lazy">
                        </div>
                        <!-- Hover overlay -->
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                    </div>
                </template>
                <!-- Duplicate for seamless loop -->
                <template x-for="(image, index) in images.slice(Math.ceil(images.length / 2))" :key="'row2-dup-' + index">
                    <div class="group relative cursor-pointer overflow-hidden rounded-xl shadow-md hover:shadow-xl transition-all duration-300 hover:scale-105 flex-shrink-0 w-80"
                        @click="openModal('{{ asset('') }}' + image)">
                        <div class="aspect-[4/3] bg-gradient-to-br from-red-100 to-green-100">
                            <img :src="'{{ asset('') }}' + image"
                                :alt="'Laravel Senegal Event ' + (index + Math.ceil(images.length / 2) + 1)"
                                class="w-full h-full object-cover"
                                loading="lazy">
                        </div>
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Stats Card -->
    <div class="flex justify-center">
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 inline-flex items-center space-x-6">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-3xl font-bold text-gray-900">500+</span>
                    </div>
                    <span class="text-sm text-gray-600">{{ __('Active developers') }}</span>
                </div>
            </div>
            <div class="h-12 w-px bg-gray-200"></div>
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <span class="text-3xl font-bold text-gray-900">{{ $events }}</span>
                    <span class="text-sm text-gray-600 block">{{ __('Total events') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div x-show="modalOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="closeModal()"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 p-4"
        style="display: none;">
        <div class="relative max-w-7xl max-h-[90vh] w-full" @click.stop>
            <!-- Close Button -->
            <button @click="closeModal()"
                class="absolute -top-4 -right-4 bg-white text-gray-800 rounded-full p-2 shadow-lg hover:bg-gray-100 transition-colors z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <!-- Modal Image -->
            <img :src="modalImage"
                alt="Laravel Senegal Event"
                class="w-full h-full object-contain rounded-lg shadow-2xl"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100">
        </div>
    </div>
</div>
