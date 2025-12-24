<div class="min-h-screen bg-black" x-data="recapStatus()" x-init="init()" @keydown.left="previous()" @keydown.right="next()">
        <!-- Progress Bars -->
        <div 
            class="absolute top-0 left-0 right-0 z-50 p-2 space-y-2"
            x-show="!showIntro"
        >
            <div class="flex gap-1">
                <template x-for="(media, index) in images" :key="index">
                    <div 
                        class="flex-1 h-1 rounded-full overflow-hidden transition-colors"
                        :class="index < currentIndex ? 'bg-red-500/30' : index === currentIndex ? 'bg-red-500/20' : 'bg-red-500/10'"
                    >
                        <div 
                            class="h-full bg-red-500 rounded-full transition-all duration-100 ease-linear"
                            :class="{ 'animate-progress': currentIndex === index && isPlaying }"
                            :style="currentIndex === index && isPlaying ? `animation-duration: ${duration}s` : index < currentIndex ? 'width: 100%' : 'width: 0%'"
                        ></div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Sound Toggle Button (only shown for videos) -->
        <button 
            @click="toggleSound()"
            class="absolute top-4 right-16 z-50 text-white hover:text-gray-300 transition-colors p-2 bg-black/30 rounded-full backdrop-blur-sm"
            aria-label="Toggle Sound"
            x-show="!showIntro && isVideo(getMediaSrc(images[currentIndex]))"
        >
            <!-- Muted Icon -->
            <svg x-show="isMuted" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" />
            </svg>
            <!-- Unmuted Icon -->
            <svg x-show="!isMuted" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
            </svg>
        </button>

        <!-- Close Button -->
        <button 
            @click="close()"
            class="absolute top-4 right-4 z-50 text-white hover:text-gray-300 transition-colors p-2"
            aria-label="Close"
            x-show="!showIntro"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Media Container -->
        <div class="relative w-full h-screen overflow-hidden">
            <template x-for="(media, index) in images" :key="index">
                <div 
                    x-show="currentIndex === index"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-105"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute inset-0 flex items-center justify-center"
                >
                    <!-- Image -->
                    <img 
                        x-show="!isVideo(getMediaSrc(media))"
                        :src="baseUrl + getMediaSrc(media)"
                        :alt="media.title || ('Laravel Senegal Recap 2025 - ' + (index + 1))"
                        class="w-full h-full object-contain"
                        style="object-fit: contain; max-width: 100%; max-height: 100%;"
                        @load="onMediaLoad(index)"
                    />
                    
                    <!-- Video -->
                    <video 
                        x-show="isVideo(getMediaSrc(media))"
                        :src="baseUrl + getMediaSrc(media)"
                        class="w-full h-full object-contain"
                        style="object-fit: contain; max-width: 100%; max-height: 100%;"
                        autoplay
                        :loop="index < images.length - 1"
                        :muted="isMuted"
                        playsinline
                        preload="auto"
                        @loadeddata="onVideoReady(index, $event.target)"
                        @canplay="onVideoReady(index, $event.target)"
                        @canplaythrough="onVideoReady(index, $event.target)"
                        @play="onVideoReady(index, $event.target)"
                        @ended="onVideoEnded(index)"
                    ></video>
                    
                    <!-- Year 2025 and Title Overlay - Modern Design -->
                    <div class="absolute bottom-0 left-0 right-0 z-40 text-center pointer-events-none pb-20 px-4">
                        <div class="relative inline-block max-w-4xl">
                            <!-- Gradient Background -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent blur-xl rounded-t-full -mx-8 -my-4"></div>
                            
                            <!-- Title - Subtle and Clean -->
                            <div 
                                x-show="currentIndex === index && (media.title || '').length > 0"
                                class="relative mb-3"
                            >
                                <p 
                                    class="text-white/90 font-medium text-sm md:text-base lg:text-lg px-6"
                                    :class="currentIndex === index ? 'animate-fade-in-up' : ''"
                                    style="text-shadow: 0 2px 8px rgba(0,0,0,0.8), 0 0 15px rgba(0,0,0,0.6); line-height: 1.5;"
                                    x-text="media.title"
                                ></p>
                            </div>
                            
                            <!-- Year Text with Modern Styling -->
                            <div 
                                class="relative text-white font-black tracking-[0.2em]"
                                :class="currentIndex === index ? (index % 4 === 0 ? 'animate-zoom-in' : index % 4 === 1 ? 'animate-fade-in-up' : index % 4 === 2 ? 'animate-fade-in-down' : 'animate-rotate-in') : ''"
                                style="font-size: clamp(3rem, 12vw, 7rem); text-shadow: 0 0 60px rgba(255,255,255,0.3), 0 0 100px rgba(255,255,255,0.2), 0 4px 20px rgba(0,0,0,0.9), 4px 4px 8px rgba(0,0,0,0.8); letter-spacing: 0.15em;"
                                x-text="index === images.length - 1 ? '2026' : '2025'"
                            >
                                2025
                            </div>
                            
                            <!-- Modern Decorative Line -->
                            <div class="relative mt-4 flex items-center justify-center gap-3">
                                <div 
                                    class="h-px bg-gradient-to-r from-transparent via-white/60 to-white/60"
                                    :class="currentIndex === index ? (index % 2 === 0 ? 'animate-slide-in-right' : 'animate-slide-in-left') : ''"
                                    style="width: 60px;"
                                ></div>
                                <div 
                                    class="w-1.5 h-1.5 bg-white rounded-full"
                                    :class="currentIndex === index ? 'animate-pulse-slow' : ''"
                                    style="box-shadow: 0 0 15px rgba(255,255,255,0.9);"
                                ></div>
                                <div 
                                    class="h-px bg-gradient-to-l from-transparent via-white/60 to-white/60"
                                    :class="currentIndex === index ? (index % 2 === 0 ? 'animate-slide-in-left' : 'animate-slide-in-right') : ''"
                                    style="width: 60px;"
                                ></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modern Floating Particles - Subtle -->
                    <div class="absolute inset-0 pointer-events-none overflow-hidden" x-show="currentIndex === index">
                        <template x-for="i in 6" :key="i">
                            <div 
                                class="absolute bg-white/20 rounded-full blur-sm"
                                :class="currentIndex === index ? 'animate-float' : ''"
                                :style="`
                                    width: ${i % 3 === 0 ? '3px' : i % 3 === 1 ? '5px' : '2px'}; 
                                    height: ${i % 3 === 0 ? '3px' : i % 3 === 1 ? '5px' : '2px'}; 
                                    left: ${15 + i * 12}%; 
                                    top: ${20 + (i % 3) * 25}%; 
                                    animation-delay: ${i * 0.5}s;
                                `"
                            ></div>
                        </template>
                    </div>
                </div>
            </template>
        </div>

        <!-- Navigation Areas -->
        <div 
            class="absolute inset-0 z-40 flex"
            x-show="!showIntro"
        >
            <!-- Previous (Left Side) -->
            <div 
                class="w-1/2 h-full cursor-pointer"
                @click="previous()"
                @touchstart="touchStart($event)"
                @touchend="touchEnd($event, 'previous')"
            ></div>
            <!-- Next (Right Side) -->
            <div 
                class="w-1/2 h-full cursor-pointer"
                @click="next()"
                @touchstart="touchStart($event)"
                @touchend="touchEnd($event, 'next')"
            ></div>
        </div>

        <!-- Navigation Arrows (Desktop) -->
        <button 
            @click="previous()"
            class="absolute left-4 top-1/2 -translate-y-1/2 z-50 text-white/80 hover:text-white transition-colors p-2 hidden md:block"
            x-show="!showIntro && currentIndex > 0"
            aria-label="Previous"
        >
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button 
            @click="next()"
            class="absolute right-4 top-1/2 -translate-y-1/2 z-50 text-white/80 hover:text-white transition-colors p-2 hidden md:block"
            x-show="!showIntro && currentIndex < images.length - 1"
            aria-label="Next"
        >
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        <!-- Media Counter -->
        <div 
            class="absolute top-6 left-6 z-50 text-white/70 text-xs font-medium bg-black/30 backdrop-blur-sm px-3 py-1.5 rounded-full border border-white/10"
            x-show="!showIntro"
        >
            <span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
        </div>

        <!-- Views Counter -->
        <div 
            class="absolute top-6 right-6 z-50 text-white/80 text-sm font-medium bg-black/40 backdrop-blur-sm px-4 py-2 rounded-full border border-white/10 flex items-center gap-2"
            x-show="!showIntro"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <span>{{ number_format($viewsCount, 0, ',', ' ') }}</span>
        </div>
    </div>

    <script>
    function recapStatus() {
        return {
            images: @js($images),
            baseUrl: '{{ asset('') }}',
            currentIndex: 0,
            isPlaying: false,
            duration: 5, // seconds per media item
            timer: null,
            touchStartX: 0,
            touchEndX: 0,
            showIntro: false, // Start directly in slideshow mode
            videos: {},
            isMuted: true, // Start muted for autoplay compatibility

            getMediaSrc(media) {
                return media && typeof media === 'object' ? media.src : media;
            },

            isVideo(src) {
                const mediaSrc = this.getMediaSrc(src);
                return mediaSrc && (mediaSrc.toLowerCase().endsWith('.mp4') || mediaSrc.toLowerCase().endsWith('.webm') || mediaSrc.toLowerCase().endsWith('.ogg'));
            },

            toggleSound() {
                this.isMuted = !this.isMuted;
                // Update current video mute state
                if (this.videos[this.currentIndex]) {
                    this.videos[this.currentIndex].muted = this.isMuted;
                }
            },

            init() {
                // Prevent body scroll
                document.body.style.overflow = 'hidden';
                // Start timer immediately since we skip intro
                this.currentIndex = 0;
                setTimeout(() => {
                    this.startTimer();
                    // Also check if first media is a video and trigger play
                    this.$nextTick(() => {
                        const firstMedia = this.images[0];
                        const firstSrc = this.getMediaSrc(firstMedia);
                        if (this.isVideo(firstSrc)) {
                            // Give video time to load, then try to play
                            setTimeout(() => {
                                const videoElement = document.querySelector(`video[src*="${firstSrc}"]`);
                                if (videoElement && videoElement.paused) {
                                    videoElement.play().catch(() => {});
                                }
                            }, 300);
                        }
                    });
                }, 500);
            },

            startTimer() {
                // Check if current media is a video
                const currentMedia = this.images[this.currentIndex];
                const currentSrc = this.getMediaSrc(currentMedia);
                
                if (this.isVideo(currentSrc)) {
                    // For videos, don't use timer - let video play and handle on ended
                    this.isPlaying = true;
                    return;
                }
                
                // For images, use timer
                this.isPlaying = true;
                this.timer = setTimeout(() => {
                    if (this.currentIndex < this.images.length - 1) {
                        this.next();
                    } else {
                        this.close();
                    }
                }, this.duration * 1000);
            },

            stopTimer() {
                if (this.timer) {
                    clearTimeout(this.timer);
                    this.timer = null;
                }
                this.isPlaying = false;
            },

            resetTimer() {
                this.stopTimer();
                this.startTimer();
                // If new media is a video, ensure it starts playing
                this.$nextTick(() => {
                    const currentMedia = this.images[this.currentIndex];
                    const currentSrc = this.getMediaSrc(currentMedia);
                    if (this.isVideo(currentSrc)) {
                        // Give video a moment to be in the DOM, then try to play
                        setTimeout(() => {
                            const videoEl = this.videos[this.currentIndex];
                            if (videoEl) {
                                if (videoEl.paused) {
                                    videoEl.play().catch(() => {});
                                }
                            } else {
                                // If video not in cache, find it in DOM
                                const videoElement = document.querySelector(`video[src*="${currentSrc.split('/').pop()}"]`);
                                if (videoElement) {
                                    this.videos[this.currentIndex] = videoElement;
                                    videoElement.muted = this.isMuted;
                                    videoElement.loop = this.currentIndex < this.images.length - 1;
                                    videoElement.play().catch(() => {});
                                }
                            }
                        }, 200);
                    }
                });
            },

            next() {
                // Stop current video if playing
                this.stopCurrentVideo();
                
                if (this.currentIndex < this.images.length - 1) {
                    this.currentIndex++;
                    this.resetTimer();
                    // Update mute state for new video
                    this.updateVideoMuteState();
                }
            },

            previous() {
                // Stop current video if playing
                this.stopCurrentVideo();
                
                if (this.currentIndex > 0) {
                    this.currentIndex--;
                    this.resetTimer();
                    // Update mute state for new video
                    this.updateVideoMuteState();
                }
            },

            updateVideoMuteState() {
                // Update mute state when switching to a video
                this.$nextTick(() => {
                    if (this.videos[this.currentIndex]) {
                        this.videos[this.currentIndex].muted = this.isMuted;
                    }
                });
            },

            stopCurrentVideo() {
                if (this.videos[this.currentIndex]) {
                    this.videos[this.currentIndex].pause();
                    this.videos[this.currentIndex] = null;
                }
            },

            touchStart(event) {
                this.touchStartX = event.touches[0].clientX;
                this.stopTimer();
            },

            touchEnd(event, action) {
                this.touchEndX = event.changedTouches[0].clientX;
                const diff = this.touchStartX - this.touchEndX;
                
                if (Math.abs(diff) > 50) { // Minimum swipe distance
                    if (diff > 0) {
                        this.next();
                    } else {
                        this.previous();
                    }
                } else {
                    this.resetTimer();
                }
            },

            onMediaLoad(index) {
                // Image loaded, ensure timer is running if it's the current index
                const media = this.images[index];
                const mediaSrc = this.getMediaSrc(media);
                if (index === this.currentIndex && !this.isVideo(mediaSrc) && !this.timer) {
                    this.resetTimer();
                }
            },

            onVideoReady(index, videoElement) {
                if (videoElement && index === this.currentIndex) {
                    this.videos[index] = videoElement;
                    // Set mute state
                    videoElement.muted = this.isMuted;
                    // Set loop based on whether it's the last video (last video should not loop)
                    const isLastVideo = index === this.images.length - 1;
                    videoElement.loop = !isLastVideo;
                    
                    // Ensure video plays - always try to play, even if not paused
                    const tryPlay = () => {
                        if (videoElement.paused || videoElement.readyState < 2) {
                            videoElement.play().catch((error) => {
                                // If autoplay fails, try again after a short delay
                                setTimeout(tryPlay, 500);
                            });
                        }
                    };
                    tryPlay();
                }
            },

            onVideoEnded(index) {
                // When video ends, move to next or close if last
                if (index === this.currentIndex) {
                    const isLastSlide = this.currentIndex === this.images.length - 1;
                    if (isLastSlide) {
                        // Last slide ended, close and redirect
                        this.close();
                    } else {
                        this.next();
                    }
                }
            },

            close() {
                this.stopTimer();
                // Stop any playing videos
                Object.values(this.videos).forEach(video => {
                    if (video) video.pause();
                });
                this.videos = {};
                document.body.style.overflow = '';
                // Redirect to home page
                window.location.href = '{{ route('welcome') }}';
            }
        }
    }
    </script>

