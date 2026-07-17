@extends('layouts.public')

@section('title', 'About')
@section('seo_title', 'About — Kona Fight Camp Bali | Real Muay Thai, No Gimmicks')
@section('meta_description', 'Kona Fight Camp is built on authentic Muay Thai — not Instagram trends. Our coaches have 20+ years of experience training and competing in Thailand. All levels welcome in North Canggu, Bali.')
@section('meta_keywords', 'about Kona Fight Camp, Muay Thai gym Bali, authentic Muay Thai Bali, Canggu fight gym, real Muay Thai training, Muay Thai history Bali')
@section('og_title', 'About — Kona Fight Camp Bali')
@section('og_description', 'Real Muay Thai, done properly. No gimmicks, no shortcuts. Coaches with 20+ years experience training &amp; competing in Thailand. North Canggu, Bali.')

@section('content')
<main>
  <x-breadcrumb title="ABOUT US" current="About" />

  <!-- ===== ABOUT ===== -->
  <section id="about" class="py-20 bg-brand-dark">
    <div class="max-w-7xl mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div class="fade-up order-2 md:order-1">
          <p class="text-brand-red text-xs font-bold tracking-widest mb-3">WHO WE ARE</p>
          <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-2"><span class="section-border-bottom pb-1">REAL MUAY THAI</span></h2>
          <div class="w-16 h-1 bg-brand-red mt-4 mb-6"></div>
          <p class="text-gray-300 leading-relaxed mb-4">
            <strong class="text-white">Kona Fight Camp</strong> is not built around Instagram fitness trends or commercial gym culture. Our focus is authentic Muay Thai, real fight knowledge, and raising the standard of Muay Thai in Indonesia.
          </p>
          <p class="text-gray-400 leading-relaxed mb-4">
            Our coaches bring over 20 years of Muay Thai experience, having lived, trained, and competed professionally in Thailand under experienced Thai trainers.
          </p>
          <p class="text-gray-400 leading-relaxed mb-4">
            We built Kona Fight Camp to create an environment with genuine athlete development pathways, catering to all levels — from complete beginners and casual practitioners to active fighters and professional athletes.
          </p>
          <p class="text-gray-400 leading-relaxed mb-4">
            We follow the same structured daily training system used throughout Thailand and offer both half and full training sessions. Half sessions are designed for beginners, casual members, and those focused on fitness and technique, while full sessions include daily sparring and clinching for more experienced practitioners looking to push themselves and develop at a higher level.
          </p>
          <p class="text-white font-semibold leading-relaxed mb-1">
            This is real Muay Thai, done properly.
          </p>
          <p class="text-brand-red font-extrabold tracking-wide leading-relaxed mb-6">
            No gimmicks. No shortcuts.
          </p>
          <div class="grid grid-cols-2 gap-4 mb-8">
            <div class="bg-[#111111] p-4 border border-brand-border shadow-md">
              <i class="fa-solid fa-user-tie text-brand-red text-xl mb-2"></i>
              <div class="text-white font-bold text-sm">Pro Coaches</div>
              <div class="text-gray-400 text-xs mt-1">Certified & experienced Muay Thai trainers</div>
            </div>
            <div class="bg-[#111111] p-4 border border-brand-border shadow-md">
              <i class="fa-solid fa-users text-brand-red text-xl mb-2"></i>
              <div class="text-white font-bold text-sm">All Levels</div>
              <div class="text-gray-400 text-xs mt-1">Beginners to advanced fighters welcome</div>
            </div>
            <div class="bg-[#111111] p-4 border border-brand-border shadow-md">
              <i class="fa-solid fa-location-dot text-brand-red text-xl mb-2"></i>
              <div class="text-white font-bold text-sm">North Canggu, Bali</div>
              <div class="text-gray-400 text-xs mt-1">Train in the heart of Canggu</div>
            </div>
            <div class="bg-[#111111] p-4 border border-brand-border shadow-md">
              <i class="fa-solid fa-clock text-brand-red text-xl mb-2"></i>
              <div class="text-white font-bold text-sm">Daily Sessions</div>
              <div class="text-gray-400 text-xs mt-1">Morning & evening training available</div>
            </div>
          </div>
          <a href="{{ route('public.contact') }}" class="btn-red px-7 py-3 font-bold text-sm tracking-widest shadow-md inline-flex items-center gap-2">
            <i class="fa-solid fa-envelope"></i> GET IN TOUCH
          </a>
        </div>
        <div class="fade-up order-1 md:order-2">
          <img src="{{ asset('img/logo.png') }}" alt="About Kona Fight Camp" class="w-full shadow-md border border-brand-border object-cover max-h-[520px]"/>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
