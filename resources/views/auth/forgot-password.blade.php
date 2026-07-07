@php
    $waNumber = preg_replace('/\D+/', '', (string) config('contact.whatsapp'));
    $waMessage = rawurlencode('Hi Admin, I forgot my Kona Fight Camp member password and need help resetting it. My email: ');
@endphp
<x-guest-layout>
    <div class="text-center">
        <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
            <i class="fa-brands fa-whatsapp"></i>
        </div>
        <h1 class="text-xl font-semibold">{{ __('Forgot your password?') }}</h1>
        <p class="text-sm text-zinc-600 mt-2">
            {{ __('For your security, password resets are handled by our admin. Message us on WhatsApp and we will help you get back in.') }}
        </p>
    </div>

    <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}" target="_blank" rel="noopener"
       class="mt-6 w-full inline-flex items-center justify-center gap-2 bg-emerald-600 text-white px-6 py-4 rounded-3xl hover:bg-emerald-700 font-medium">
        <i class="fa-brands fa-whatsapp text-lg"></i> {{ __('Contact Admin on WhatsApp') }}
    </a>

    <div class="flex items-center justify-center mt-6">
        <a class="underline text-sm text-zinc-600 hover:text-zinc-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" href="{{ route('login') }}">
            <i class="fa-solid fa-arrow-left-long me-1"></i> {{ __('Back to login') }}
        </a>
    </div>
</x-guest-layout>
