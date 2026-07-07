<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} — Member</title>

    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-zinc-900 antialiased bg-zinc-50 min-h-screen">
    <!-- Top navbar (no fixed left sidebar for the member area) -->
    <header x-data="{ open: false }" class="bg-white border-b border-zinc-100 sticky top-0 z-40">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 gap-4">
                <a href="{{ route('member.dashboard') }}" class="flex items-center gap-3 min-w-0">
                    <img src="{{ asset('logo.png') }}" alt="Kona Fight Camp" class="h-9 w-auto rounded-xl">
                    <span class="font-semibold tracking-tight truncate">Member Portal</span>
                </a>

                <!-- Desktop user menu -->
                <div class="hidden sm:flex items-center gap-3">
                    <div class="text-right leading-tight">
                        <div class="text-sm font-medium truncate max-w-[12rem]">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-emerald-600 capitalize">{{ auth()->user()->role }}</div>
                    </div>
                    <div class="w-9 h-9 bg-zinc-900 text-white rounded-2xl flex items-center justify-center text-sm font-medium">
                        {{ strtoupper(\Illuminate\Support\Str::substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <a href="{{ route('profile.edit') }}"
                       class="w-9 h-9 flex items-center justify-center rounded-2xl text-zinc-400 hover:bg-zinc-100 hover:text-zinc-700"
                       title="Profile settings" aria-label="Profile settings">
                        <i class="fa-regular fa-user"></i>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-9 h-9 flex items-center justify-center rounded-2xl text-zinc-400 hover:bg-zinc-100 hover:text-red-600"
                                title="Log out" aria-label="Log out">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>

                <!-- Mobile toggle -->
                <button @click="open = !open"
                        class="sm:hidden w-10 h-10 flex items-center justify-center rounded-2xl text-zinc-600 hover:bg-zinc-100"
                        aria-label="Menu">
                    <i class="fa-solid" :class="open ? 'fa-xmark' : 'fa-bars'"></i>
                </button>
            </div>

            <!-- Mobile menu -->
            <div x-show="open" x-cloak class="sm:hidden pb-4 space-y-2">
                <div class="px-1">
                    <div class="font-medium">{{ auth()->user()->name }}</div>
                    <div class="text-sm text-zinc-500">{{ auth()->user()->email }}</div>
                </div>
                <a href="{{ route('profile.edit') }}" class="block px-1 py-2 text-sm text-zinc-600 hover:text-zinc-900">
                    <i class="fa-regular fa-user me-2"></i> Profile settings
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-1 py-2 text-sm text-red-600">
                        <i class="fa-solid fa-right-from-bracket me-2"></i> Log out
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>
</body>
</html>
