<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4" x-data="{ showPassword: false }">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative mt-1">
                <x-text-input id="password" class="block w-full pe-10"
                                x-bind:type="showPassword ? 'text' : 'password'"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                <button type="button" @click="showPassword = !showPassword"
                        class="absolute inset-y-0 end-0 flex items-center pe-3 text-zinc-400 hover:text-zinc-600 focus:outline-none"
                        :aria-label="showPassword ? 'Hide password' : 'Show password'">
                    <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-zinc-300 text-red-600 shadow-sm focus:ring-red-500" name="remember">
                <span class="ms-2 text-sm text-zinc-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center">
                <i class="fa-solid fa-right-to-bracket"></i> {{ __('Log in') }}
            </x-primary-button>
        </div>

        @if (Route::has('register'))
            <div class="mt-3">
                <a href="{{ route('register') }}"
                   class="inline-flex items-center justify-center gap-2 w-full px-5 py-2.5 bg-white border border-zinc-200 rounded-2xl font-semibold text-sm text-zinc-700 shadow-sm hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fa-solid fa-user-plus"></i> {{ __('Register') }}
                </a>
            </div>
        @endif

        <div class="flex items-center justify-center gap-4 mt-6 text-sm">
            @if (Route::has('password.request'))
                <a class="underline text-zinc-600 hover:text-zinc-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>
