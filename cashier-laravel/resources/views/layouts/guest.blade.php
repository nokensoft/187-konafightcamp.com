@props(['maxWidth' => 'md'])
@php
    $maxWidthClass = [
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        '2xl' => 'sm:max-w-2xl',
        '3xl' => 'sm:max-w-3xl',
    ][$maxWidth] ?? 'sm:max-w-md';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-zinc-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4 bg-zinc-50">
            <a href="/" class="flex flex-col items-center gap-2">
                <img src="{{ asset('logo.png') }}" alt="Kona Fight Camp" class="h-20 w-auto rounded-2xl shadow-sm">
                <p class="text-zinc-400 text-sm">Multi-Unit POS</p>
            </a>

            <div class="w-full {{ $maxWidthClass }} mt-6 px-6 py-6 bg-white border border-zinc-100 shadow-sm overflow-hidden rounded-3xl">
                {{ $slot }}
            </div>

            <a href="{{ route('home') }}"
               class="mt-6 inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-zinc-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 rounded-md">
                <i class="fa-solid fa-arrow-left-long"></i> {{ __('Back to Home') }}
            </a>
        </div>
    </body>
</html>
