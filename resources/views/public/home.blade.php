@extends('layouts.public')

@section('title', 'Home')
@section('seo_title', 'Kona Fight Camp — Muay Thai, Boxing &amp; Conditioning · North Canggu, Bali')
@section('meta_description', 'Train Muay Thai, Boxing &amp; Conditioning at Kona Fight Camp in North Canggu, Bali. Authentic training with coaches who have 20+ years experience in Thailand. All levels welcome — from beginners to professional fighters.')
@section('meta_keywords', 'Muay Thai Bali, boxing Bali, Kona Fight Camp, fight camp Canggu, Muay Thai training Bali, martial arts Bali, kickboxing Bali, kondisioning Bali')
@section('og_title', 'Kona Fight Camp — Muay Thai, Boxing &amp; Conditioning · Bali')
@section('og_description', 'Authentic Muay Thai, Boxing &amp; Conditioning in North Canggu, Bali. Built from real experience — 20+ years. Made for fighters, open to everyone.')

@section('content')
<main>
  <!-- ===== HERO ===== -->
  <section id="home" x-data="heroSlider()" class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background slideshow (Alpine array) with zoom in/out -->
    <template x-for="(img, i) in images" :key="i">
      <img :src="img" alt="Hero background"
           class="hero-bg absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out"
           :class="current === i ? 'opacity-100' : 'opacity-0'"/>
    </template>
    <div class="hero-overlay absolute inset-0"></div>
    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto fade-up">
      <div class="inline-block border border-brand-red px-4 py-1 text-brand-red text-xs font-bold tracking-widest mb-6 shadow-md">MUAY THAI · BOXING · CONDITIONING</div>
      <h1 class="text-5xl md:text-7xl font-extrabold leading-none tracking-tight text-white mb-4 drop-shadow-lg">
        <span class="text-brand-red">KONA</span><br/>FIGHT CAMP
      </h1>
      <p class="text-white text-xl md:text-2xl font-bold mb-4 max-w-2xl mx-auto leading-relaxed">
        Built from experience in the ring, not trends in the fitness industry.
      </p>
      <p class="text-gray-300 text-base md:text-lg font-medium mb-3 max-w-2xl mx-auto leading-relaxed">
        Our coaches bring over 20 years experience fighting, training and coaching in Thailand, Australia, UK, and Indonesia.
      </p>
      <p class="text-gray-200 text-base md:text-lg font-semibold mb-8 max-w-2xl mx-auto leading-relaxed">
        Made for fighters, open to everyone.
      </p>
      <div class="flex flex-wrap gap-4 justify-center">
        <a href="{{ route('public.prices') }}" class="btn-red px-8 py-3 font-bold text-sm tracking-widest shadow-md">VIEW PRICES</a>
        <a href="{{ route('public.about') }}" class="btn-outline px-8 py-3 font-bold text-sm tracking-widest shadow-md">ABOUT US</a>
      </div>
    </div>
    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white opacity-60 animate-bounce">
      <i class="fa-solid fa-chevron-down text-xl"></i>
    </div>
  </section>

  <!-- ===== STATS BAR ===== -->
  <div class="bg-brand-red py-6">
    <div class="max-w-2xl mx-auto px-4 grid grid-cols-2 gap-6 text-center text-white">
      <div class="fade-up"><div class="text-3xl font-extrabold">20+</div><div class="text-xs font-semibold tracking-widest opacity-80 mt-1">YEARS EXPERIENCE</div></div>
      <div class="fade-up"><div class="text-3xl font-extrabold">ALL</div><div class="text-xs font-semibold tracking-widest opacity-80 mt-1">LEVELS WELCOME</div></div>
    </div>
  </div>
  
  <!-- ===== EXPLORE / SECTION LINKS ===== -->
<section class="py-20 bg-gray-50 dark:bg-brand-dark transition-colors duration-300">
  <div class="max-w-7xl mx-auto px-4">
    <div class="section-heading mb-12 fade-up text-center">
      <p class="text-brand-red text-xs font-bold tracking-widest mb-2">EXPLORE</p>
      <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white transition-colors duration-300"><span>WHAT'S INSIDE</span></h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <a href="{{ route('public.prices') }}" class="bg-white dark:bg-[#111111] p-6 border border-gray-200 dark:border-brand-border shadow-md card-hover fade-up block transition-colors duration-300">
        <i class="fa-solid fa-tags text-brand-red text-2xl mb-3"></i>
        <div class="text-gray-900 dark:text-white font-bold transition-colors duration-300">Prices</div>
        <div class="text-gray-500 dark:text-gray-400 text-xs mt-1 transition-colors duration-300">Tourist & local membership plans</div>
      </a>
      <a href="{{ route('public.about') }}" class="bg-white dark:bg-[#111111] p-6 border border-gray-200 dark:border-brand-border shadow-md card-hover fade-up block transition-colors duration-300">
        <i class="fa-solid fa-circle-info text-brand-red text-2xl mb-3"></i>
        <div class="text-gray-900 dark:text-white font-bold transition-colors duration-300">About</div>
        <div class="text-gray-500 dark:text-gray-400 text-xs mt-1 transition-colors duration-300">Who we are and what we stand for</div>
      </a>
      <a href="{{ route('public.coaches') }}" class="bg-white dark:bg-[#111111] p-6 border border-gray-200 dark:border-brand-border shadow-md card-hover fade-up block transition-colors duration-300">
        <i class="fa-solid fa-user-tie text-brand-red text-2xl mb-3"></i>
        <div class="text-gray-900 dark:text-white font-bold transition-colors duration-300">Coaches</div>
        <div class="text-gray-500 dark:text-gray-400 text-xs mt-1 transition-colors duration-300">Meet Rico, our head coach</div>
      </a>
      <a href="{{ route('public.gallery') }}" class="bg-white dark:bg-[#111111] p-6 border border-gray-200 dark:border-brand-border shadow-md card-hover fade-up block transition-colors duration-300">
        <i class="fa-solid fa-images text-brand-red text-2xl mb-3"></i>
        <div class="text-gray-900 dark:text-white font-bold transition-colors duration-300">Gallery</div>
        <div class="text-gray-500 dark:text-gray-400 text-xs mt-1 transition-colors duration-300">Inside the camp</div>
      </a>
    </div>
    <div class="text-center mt-10 fade-up">
      <a href="{{ route('public.contact') }}" class="btn-red px-8 py-3 font-bold text-sm tracking-widest shadow-md inline-flex items-center gap-2">
        <i class="fa-solid fa-envelope"></i> GET IN TOUCH
      </a>
    </div>
  </div>
</section>

</main>
@endsection

@push('scripts')
<script>
  // Hero background slideshow (img1–img5) with crossfade; zoom in/out handled by CSS
  function heroSlider() {
    return {
      images: ['{{ asset('img/img1.jpeg') }}', '{{ asset('img/img2.jpeg') }}', '{{ asset('img/img3.jpeg') }}', '{{ asset('img/img4.jpeg') }}', '{{ asset('img/img5.jpeg') }}'],
      current: 0,
      init() {
        setInterval(() => { this.current = (this.current + 1) % this.images.length; }, 5000);
      }
    }
  }
</script>
@endpush
