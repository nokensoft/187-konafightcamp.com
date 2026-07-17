@extends('layouts.public')

@section('title', 'Coaches')
@section('seo_title', 'Coaches — Kona Fight Camp Bali | Meet Rico, Head Coach')
@section('meta_description', 'Meet Rico, Head Coach at Kona Fight Camp in North Canggu, Bali. 20+ years of Muay Thai experience — trained and competed professionally in Thailand. Real coaching for all levels.')
@section('meta_keywords', 'Kona Fight Camp coach, Rico Muay Thai Bali, Muay Thai coach Canggu, fight camp head coach Bali, Muay Thai trainer Bali')
@section('og_title', 'Coaches — Kona Fight Camp Bali')
@section('og_description', 'Meet Rico — Head Coach at Kona Fight Camp, North Canggu, Bali. 20+ years of Muay Thai experience. Real training, real knowledge.')

@section('content')
<main>
  <x-breadcrumb title="COACHES" current="Coaches" />

  <!-- ===== COACHES ===== -->
  <section id="coaches" class="py-20 bg-brand-dark">
    <div class="max-w-7xl mx-auto px-4">
      <div class="section-heading mb-12 fade-up">
        <p class="text-brand-red text-xs font-bold tracking-widest mb-2">THE TEAM</p>
        <h2 class="text-3xl md:text-4xl font-extrabold text-white"><span>MEET RICO</span></h2>
        <div class="w-16 h-1 bg-brand-red mt-3"></div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <!-- Rico photos: replace ./img/rico-1..3.jpeg with real photos of Rico. Each falls back to an existing photo until you add the files. -->
        <div class="fade-up grid grid-cols-2 gap-4">
          <img src="{{ asset('img/rico-1.jpeg') }}" onerror="this.onerror=null;this.src='{{ asset('img/img2.jpeg') }}'" alt="Rico — Head Coach at Kona Fight Camp" class="col-span-2 w-full h-72 object-cover shadow-md border border-brand-border card-hover"/>
          <img src="{{ asset('img/rico-2.jpeg') }}" onerror="this.onerror=null;this.src='{{ asset('img/img3.jpeg') }}'" alt="Rico training Muay Thai" class="w-full h-44 object-cover shadow-md border border-brand-border card-hover"/>
          <img src="{{ asset('img/rico-3.jpeg') }}" onerror="this.onerror=null;this.src='{{ asset('img/img4.jpeg') }}'" alt="Rico coaching at Kona Fight Camp" class="w-full h-44 object-cover shadow-md border border-brand-border card-hover"/>
        </div>
        <div class="fade-up">
          <p class="text-brand-red text-xs font-bold tracking-widest mb-3">HEAD COACH</p>
          <h3 class="text-3xl font-extrabold text-white mb-4">Rico</h3>
          <!-- TODO: replace with Rico's full bio -->
          <p class="text-gray-300 leading-relaxed mb-4">
            Rico leads the coaching at Kona Fight Camp. Our coaches bring over 20 years of Muay Thai experience, having lived, trained, and competed professionally in Thailand under experienced Thai trainers.
          </p>
          <p class="text-gray-400 leading-relaxed mb-6">
            His sessions follow the same structured daily training system used throughout Thailand — building real fight knowledge and technique for everyone from complete beginners to professional athletes.
          </p>
          <a href="https://wa.me/6285119339311?text=Hi%20Kona%20Fight%20Camp%2C%20I%27d%20like%20to%20train%20with%20Rico" target="_blank" class="btn-red px-7 py-3 font-bold text-sm tracking-widest shadow-md inline-flex items-center gap-2">
            <i class="fa-brands fa-whatsapp"></i> TRAIN WITH RICO
          </a>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
