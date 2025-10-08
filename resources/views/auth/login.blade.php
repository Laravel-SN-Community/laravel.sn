<x-guest-layout>
    <div class="bg-slate-100">
        <div class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
            <div
                class="grid overflow-hidden rounded-3xl bg-white shadow-2xl ring-1 ring-black/5 md:grid-cols-[minmax(0,1fr),minmax(0,1.05fr)]">
                <div class="flex flex-col justify-between px-8 py-12 sm:px-12">
                    <div class="space-y-8">
                        <div class="flex items-center gap-3">
                            <div class="rounded-2xl bg-slate-100 p-3">
                                <x-authentication-card-logo />
                            </div>
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-wide text-indigo-500">Laravel Senegal</p>
                                <p class="text-sm text-slate-500">Communauté des développeurs Laravel</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <h1 class="text-3xl font-semibold text-slate-900 sm:text-4xl">{{ __('Welcome back') }}</h1>
                            <p class="text-base text-slate-500">
                                {{ __('Enter your credentials to access your account and stay up-to-date with the community news.') }}
                            </p>
                        </div>

                        <x-validation-errors class="rounded-xl border border-red-100 bg-red-50 p-4 text-sm text-red-600" />

                        @session('status')
                            <div class="rounded-xl border border-emerald-100 bg-emerald-50 p-4 text-sm text-emerald-600">
                                {{ $value }}
                            </div>
                        @endsession

                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf

                            <div class="space-y-2">
                                <x-label for="email" value="{{ __('Email address') }}" class="text-sm font-medium text-slate-700" />
                                <x-input
                                    id="email"
                                    class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-xs transition focus:border-indigo-500 focus:ring-indigo-500"
                                    type="email"
                                    name="email"
                                    :value="old('email')"
                                    required
                                    autofocus
                                    autocomplete="username"
                                />
                            </div>

                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <x-label for="password" value="{{ __('Password') }}" class="text-sm font-medium text-slate-700" />
                                    @if (Route::has('password.request'))
                                        <a
                                            class="text-sm font-medium text-indigo-500 transition hover:text-indigo-600"
                                            href="{{ route('password.request') }}"
                                        >
                                            {{ __('Forgot your password?') }}
                                        </a>
                                    @endif
                                </div>
                                <x-input
                                    id="password"
                                    class="block w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-xs transition focus:border-indigo-500 focus:ring-indigo-500"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                />
                            </div>

                            <label for="remember_me" class="flex items-center gap-3">
                                <x-checkbox id="remember_me" name="remember" />
                                <span class="text-sm text-slate-600">{{ __('Remember me') }}</span>
                            </label>

                            <x-button
                                class="flex w-full items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg shadow-indigo-600/30 transition hover:bg-indigo-500 focus:bg-indigo-500">
                                {{ __('Log in') }}
                            </x-button>
                        </form>
                    </div>

                    <div class="mt-8 space-y-6">
                        <div class="space-y-2">
                            <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">{{ __('Or log in with') }}</p>
                            <div class="grid gap-3 sm:grid-cols-2">
                                <a
                                    href="#"
                                    class="flex items-center justify-center gap-3 rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-600 transition hover:border-indigo-200 hover:text-indigo-600"
                                >
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            fill="#EA4335"
                                            d="M12 11h11c.06.32.09.65.09 1 0 5.52-4.48 10-10 10a9.99 9.99 0 01-9.45-6.9l3.89-3.02A5.99 5.99 0 0012 17c1.62 0 3.09-.62 4.21-1.64L12 11z"
                                        />
                                        <path
                                            fill="#34A853"
                                            d="M2.55 14.1A9.99 9.99 0 0112 2c2.7 0 5.15 1.06 6.93 2.78l-3.54 3.54A5.96 5.96 0 0012 5c-2.45 0-4.51 1.58-5.26 3.78l-4.19-3.24z"
                                        />
                                        <path
                                            fill="#FBBC05"
                                            d="M6.74 8.78A5.98 5.98 0 006 11c0 .74.13 1.44.34 2.1l-3.89 3.02A9.98 9.98 0 012 11c0-1.12.19-2.2.55-3.19l4.19 3.24z"
                                        />
                                        <path
                                            fill="#4285F4"
                                            d="M23 12c0-.34-.03-.68-.09-1H12V8h11a10 10 0 010 4z"
                                        />
                                    </svg>
                                    <span>{{ __('Google') }}</span>
                                </a>
                                <a
                                    href="#"
                                    class="flex items-center justify-center gap-3 rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-600 transition hover:border-indigo-200 hover:text-indigo-600"
                                >
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
                                        <path
                                            d="M12 2C6.477 2 2 6.486 2 12.012c0 4.424 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.009-.868-.014-1.704-2.782.605-3.369-1.342-3.369-1.342-.455-1.156-1.11-1.464-1.11-1.464-.907-.62.069-.608.069-.608 1.004.07 1.532 1.034 1.532 1.034.892 1.529 2.341 1.088 2.91.833.091-.647.35-1.088.636-1.338-2.221-.253-4.555-1.112-4.555-4.95 0-1.093.39-1.988 1.029-2.688-.103-.254-.446-1.277.098-2.664 0 0 .84-.27 2.75 1.027a9.564 9.564 0 012.503-.337c.849.004 1.705.115 2.503.337 1.909-1.296 2.748-1.027 2.748-1.027.546 1.387.203 2.41.1 2.664.64.7 1.028 1.595 1.028 2.688 0 3.847-2.338 4.694-4.566 4.942.359.31.678.92.678 1.855 0 1.338-.012 2.419-.012 2.749 0 .268.18.58.688.481A10.013 10.013 0 0022 12.012C22 6.486 17.523 2 12 2z"
                                        />
                                    </svg>
                                    <span>{{ __('GitHub') }}</span>
                                </a>
                            </div>
                        </div>
                        <p class="text-sm text-slate-500">
                            {{ __('Don\'t have an account?') }}
                            <a href="{{ route('register') }}" class="font-semibold text-indigo-500 transition hover:text-indigo-600">
                                {{ __('Register now') }}
                            </a>
                        </p>
                    </div>
                </div>

                <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-indigo-500 to-blue-500 px-8 py-12 text-white sm:px-12">
                    <div class="absolute left-1/2 top-1/3 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white/10 blur-3xl" style="width: 420px; height: 420px;"></div>
                    <div class="absolute -top-24 -right-16 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
                    <div class="absolute -bottom-24 -left-16 h-64 w-64 rounded-full bg-indigo-400/30 blur-3xl"></div>
                    <div class="relative z-10 flex h-full flex-col justify-between">
                        <div class="space-y-4">
                            <span class="inline-flex items-center rounded-full bg-white/15 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-white/80">
                                {{ __('Communauté Laravel Sénégal') }}
                            </span>
                            <h2 class="text-3xl font-semibold leading-tight text-white sm:text-4xl">
                                {{ __('Effortlessly manage your journey in the community.') }}
                            </h2>
                            <p class="text-base text-white/80">
                                {{ __('Connect with fellow developers, share knowledge, and grow your Laravel expertise with resources curated by the community.') }}
                            </p>
                        </div>

                        <div class="mt-10">
                            <div class="overflow-hidden rounded-3xl border border-white/20 bg-white/10 p-4 backdrop-blur">
                                <img
                                    src="{{ asset('images/Laravelsn.png') }}"
                                    alt="Illustration de la communauté Laravel Sénégal"
                                    class="w-full rounded-2xl object-cover"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
