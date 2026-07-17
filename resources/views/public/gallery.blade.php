@extends('layouts.public')

@section('title', 'Gallery')
@section('seo_title', 'Gallery — Kona Fight Camp Bali | Inside the Camp')
@section('meta_description', 'See inside Kona Fight Camp, North Canggu, Bali. Photos of Muay Thai training sessions, sparring, conditioning, and the team. Follow us on Instagram @konafightcamp.')
@section('meta_keywords', 'Kona Fight Camp gallery, Muay Thai gym photos Bali, fight camp Canggu photos, boxing training Bali, Muay Thai sparring Bali')
@section('og_title', 'Gallery — Kona Fight Camp Bali')
@section('og_description', 'Inside Kona Fight Camp — North Canggu, Bali. Muay Thai training sessions, sparring, and more. Follow @konafightcamp on Instagram.')

@section('content')
<main>
  <x-breadcrumb title="GALLERY" current="Gallery" />

  <!-- ===== GALLERY ===== -->
  <section id="gallery" class="py-20 bg-[#0a0a0a]">
    <div class="max-w-7xl mx-auto px-4">
      <div class="section-heading mb-12 fade-up">
        <p class="text-brand-red text-xs font-bold tracking-widest mb-2">INSIDE THE CAMP</p>
        <h2 class="text-3xl md:text-4xl font-extrabold text-white"><span>MOMENTS</span></h2>
        <div class="w-16 h-1 bg-brand-red mt-3"></div>
      </div>
      <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <div class="fade-up col-span-2 md:col-span-2 row-span-1">
          <img src="{{ asset('img/img1.jpeg') }}" alt="Gallery 1" class="w-full h-full md:h-72 object-cover shadow-md border border-brand-border card-hover"/>
        </div>
        <div class="fade-up">
          <img src="{{ asset('img/img2.jpeg') }}" alt="Gallery 2" class="w-full h-full md:h-72 object-cover shadow-md border border-brand-border card-hover"/>
        </div>
        <div class="fade-up">
          <img src="{{ asset('img/img3.jpeg') }}" alt="Gallery 3" class="w-full h-full object-cover shadow-md border border-brand-border card-hover"/>
        </div>
        <div class="fade-up">
          <img src="{{ asset('img/img4.jpeg') }}" alt="Gallery 4" class="w-full h-full object-cover shadow-md border border-brand-border card-hover"/>
        </div>
        <div class="fade-up">
          <img src="{{ asset('img/img5.jpeg') }}" alt="Gallery 5" class="w-full h-full object-cover shadow-md border border-brand-border card-hover"/>
        </div>
      </div>
      <div class="text-center mt-8 fade-up">
        <a href="https://www.instagram.com/konafightcamp/" target="_blank" class="btn-outline px-7 py-3 font-bold text-sm tracking-widest shadow-md inline-flex items-center gap-2">
          <i class="fa-brands fa-instagram text-brand-red"></i> MORE ON INSTAGRAM
        </a>
      </div>
    </div>
  </section>
</main>
@endsection
