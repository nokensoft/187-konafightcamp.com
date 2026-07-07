<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cashier Dashboard — Kona Fight Camp</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-zinc-50 text-zinc-900 font-sans">
    <div x-data="posApp(@js($units), @js($role))" x-cloak class="flex h-screen overflow-hidden">
        @include('pos.partials.sidebar')

        <!-- Main Area -->
        <div class="flex-1 flex flex-col">
            @include('pos.partials.header')

            <!-- Content -->
            <div class="flex-1 overflow-auto p-4 lg:p-8">
                @include('pos.partials.dashboard')
                @include('pos.partials.pos')
                @include('pos.partials.members')
                @include('pos.partials.inventory')
                @include('pos.partials.trash')
                @include('pos.partials.notifications')
                @include('pos.partials.userlogs')
            </div>
        </div>

        @include('pos.partials.modals')
        @include('pos.partials.toast')

        <!-- Loading overlay -->
        <div x-show="loading" x-cloak class="fixed inset-0 bg-white flex items-center justify-center z-[60]">
            <div class="text-center text-zinc-400">
                <i class="fa-solid fa-circle-notch fa-spin text-4xl mb-4"></i>
                <div>Loading data…</div>
            </div>
        </div>
    </div>
</body>
</html>
