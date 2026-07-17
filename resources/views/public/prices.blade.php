@extends('layouts.public')

@section('title', 'Prices')
@section('seo_title', 'Prices — Kona Fight Camp Bali | Muay Thai &amp; Boxing Membership')
@section('meta_description', 'View Kona Fight Camp membership prices in Bali. Drop-in sessions from Rp 60K, session packages, and unlimited plans for tourists and Indonesian locals. Book via WhatsApp.')
@section('meta_keywords', 'Muay Thai prices Bali, fight camp membership Bali, boxing session Canggu, Kona Fight Camp prices, Muay Thai drop-in Bali, unlimited Muay Thai Bali')
@section('og_title', 'Prices — Kona Fight Camp Bali')
@section('og_description', 'Drop-in sessions, session packages &amp; unlimited plans at Kona Fight Camp, North Canggu, Bali. Separate tourist &amp; local pricing available.')

@section('content')
<main>
  <x-breadcrumb title="PRICES" current="Prices" />

  
  <!-- ===== PRICES ===== -->
  <section id="prices" class="py-20 bg-brand-dark">
    <div class="max-w-7xl mx-auto px-4">
      <div class="section-heading mb-12 fade-up">
        <p class="text-brand-red text-xs font-bold tracking-widest mb-2">MEMBERSHIP</p>
        <h2 class="text-3xl md:text-4xl font-extrabold text-white"><span>CHOOSE YOUR PLAN</span></h2>
        <div class="w-16 h-1 bg-brand-red mt-3"></div>
      </div>
      <!-- Filter Tabs -->
      <div x-data="{ tab: 'tourist' }" class="fade-up">
        <div class="flex gap-3 mb-10 flex-wrap">
          <button @click="tab='tourist'" :class="tab==='tourist' ? 'active' : ''" class="tab-btn btn-outline px-6 py-2 text-xs font-bold tracking-widest shadow-md transition-all">
            <i class="fa-solid fa-globe mr-2"></i>TOURIST PRICES (NON-KTP)
          </button>
          <button @click="tab='local'" :class="tab==='local' ? 'active' : ''" class="tab-btn btn-outline px-6 py-2 text-xs font-bold tracking-widest shadow-md transition-all">
            <i class="fa-solid fa-flag mr-2"></i>INDONESIAN LOCAL (KTP HOLDER)
          </button>
        </div>

        <!-- TOURIST PRICES (NON-KTP) -->
        <div x-show="tab==='tourist'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

            <!-- Per Session -->
            <div class="price-card bg-[#111111] p-6 shadow-md card-hover border border-brand-border md:col-span-1">
              <div class="text-brand-red text-xs font-bold tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-dumbbell"></i> PER SESSION</div>
              <div class="space-y-4">
                <div class="py-2 border-b border-brand-border">
                  <div class="flex justify-between items-center">
                    <div class="font-semibold text-white text-sm">Half Session (60 mins)</div>
                    <div class="text-brand-red font-bold text-sm">Rp 135K</div>
                  </div>
                  <div class="text-gray-400 text-xs mt-1 italic">warm up, stretching, shadow, bagwork & padwork</div>
                </div>
                <div class="py-2 border-b border-brand-border highlight-row px-2">
                  <div class="flex justify-between items-center">
                    <div class="font-semibold text-white text-sm">Full Session (90-120 mins)</div>
                    <div class="text-brand-red font-bold text-sm">Rp 200K</div>
                  </div>
                  <div class="text-gray-400 text-xs mt-1 italic">technique work, sparring, clinching - after half session</div>
                </div>
                <div class="py-2 border-b border-brand-border">
                  <div class="flex justify-between items-center">
                    <div class="font-semibold text-white text-sm">Open Mat (120 mins)</div>
                    <div class="text-brand-red font-bold text-sm">Rp 100K</div>
                  </div>
                  <div class="text-gray-400 text-xs mt-1 italic">training alone</div>
                </div>
                <div class="py-2 highlight-row px-2">
                  <div class="flex justify-between items-center">
                    <div class="font-semibold text-white text-sm">Private 1-2-1 Training (60 mins)</div>
                    <div class="text-brand-red font-bold text-sm">Rp 500K</div>
                  </div>
                  <div class="text-gray-400 text-xs mt-1 italic">You choose what you want to focus on, eg. technique, fitness, clinching, sparring etc</div>
                </div>
              </div>
            </div>

            <!-- Memberships Table Grid -->
            <div class="price-card bg-[#111111] p-6 shadow-md card-hover border border-brand-border md:col-span-2">
              <div class="text-brand-red text-xs font-bold tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-infinity"></i> MEMBERSHIPS</div>
              <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-400">
                  <thead class="thead-table text-xs uppercase text-white font-bold tracking-wider">
                    <tr>
                      <th scope="col" class="px-4 py-3">Membership</th>
                      <th scope="col" class="px-4 py-3 text-center">Weekly</th>
                      <th scope="col" class="px-4 py-3 text-center">Monthly</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-brand-border">
                    <tr class="border-b border-brand-border">
                      <td class="px-4 py-4 font-semibold text-white">Half session daily</td>
                      <td class="px-4 py-4 text-center text-brand-red font-bold">600k</td>
                      <td class="px-4 py-4 text-center text-brand-red font-bold">1.3M</td>
                    </tr>
                    <tr class="border-b border-brand-border highlight-row">
                      <td class="px-4 py-4 font-semibold text-white">Full session daily</td>
                      <td class="px-4 py-4 text-center text-brand-red font-bold">800k</td>
                      <td class="px-4 py-4 text-center text-brand-red font-bold">1.7M</td>
                    </tr>
                    <tr class="highlight-row">
                      <td class="px-4 py-4 font-semibold text-white">Unlimited twice daily</td>
                      <td class="px-4 py-4 text-center text-brand-red font-bold">1.2M</td>
                      <td class="px-4 py-4 text-center text-brand-red font-bold">2M</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>

        <!-- LOCAL PRICES (KTP HOLDER) -->
        <div x-show="tab==='local'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

            <!-- Harga Per Sesi -->
            <div class="price-card bg-[#111111] p-6 shadow-md card-hover border border-brand-border md:col-span-1">
              <div class="text-brand-red text-xs font-bold tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-dumbbell"></i> HARGA PER SESI</div>
              <div class="space-y-4">
                <div class="py-2 border-b border-brand-border">
                  <div class="flex justify-between items-center">
                    <div class="font-semibold text-white text-sm">Sesi Setengah (60 menit)</div>
                    <div class="text-brand-red font-bold text-sm">Rp 95K</div>
                  </div>
                  <div class="text-gray-400 text-xs mt-1 italic">pemanasan, peregangan, shadow boxing, latihan samsak & latihan pad</div>
                </div>
                <div class="py-2 border-b border-brand-border highlight-row px-2">
                  <div class="flex justify-between items-center">
                    <div class="font-semibold text-white text-sm">Sesi Penuh (90–120 menit)</div>
                    <div class="text-brand-red font-bold text-sm">Rp 135K</div>
                  </div>
                  <div class="text-gray-400 text-xs mt-1 italic">pengembangan teknik, sparring & clinching — dilanjutkan setelah sesi setengah</div>
                </div>
                <div class="py-2 border-b border-brand-border">
                  <div class="flex justify-between items-center">
                    <div class="font-semibold text-white text-sm">Open Mat (120 menit)</div>
                    <div class="text-brand-red font-bold text-sm">Rp 75K</div>
                  </div>
                  <div class="text-gray-400 text-xs mt-1 italic">latihan mandiri</div>
                </div>
                <div class="py-2 highlight-row px-2">
                  <div class="flex justify-between items-center">
                    <div class="font-semibold text-white text-sm">Latihan Privat 1-on-1 (60 menit)</div>
                    <div class="text-brand-red font-bold text-sm">Rp 400K</div>
                  </div>
                  <div class="text-gray-400 text-xs mt-1 italic">Anda dapat memilih fokus latihan, misalnya teknik, kebugaran, clinching, sparring, dan lain-lain</div>
                </div>
              </div>
            </div>

            <!-- Keanggotaan Table Grid -->
            <div class="price-card bg-[#111111] p-6 shadow-md card-hover border border-brand-border md:col-span-2">
              <div class="text-brand-red text-xs font-bold tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-infinity"></i> KEANGGOTAAN</div>
              <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-400">
                  <thead class="thead-table text-xs uppercase text-white font-bold tracking-wider">
                    <tr>
                      <th scope="col" class="px-4 py-3">Membership</th>
                      <th scope="col" class="px-4 py-3 text-center">Weekly</th>
                      <th scope="col" class="px-4 py-3 text-center">Monthly</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-brand-border">
                    <tr class="border-b border-brand-border">
                      <td class="px-4 py-4 font-semibold text-white">Half session daily</td>
                      <td class="px-4 py-4 text-center text-brand-red font-bold">350k</td>
                      <td class="px-4 py-4 text-center text-brand-red font-bold">750k</td>
                    </tr>
                    <tr class="border-b border-brand-border highlight-row">
                      <td class="px-4 py-4 font-semibold text-white">Full session daily</td>
                      <td class="px-4 py-4 text-center text-brand-red font-bold">450k</td>
                      <td class="px-4 py-4 text-center text-brand-red font-bold">900k</td>
                    </tr>
                    <tr class="highlight-row">
                      <td class="px-4 py-4 font-semibold text-white">Unlimited twice daily</td>
                      <td class="px-4 py-4 text-center text-brand-red font-bold">600k</td>
                      <td class="px-4 py-4 text-center text-brand-red font-bold">1.3M</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>

        <div class="mt-10 text-center fade-up">
          <a href="https://wa.me/6285119339311?text=Hi%20Kona%20Fight%20Camp%2C%20I%27d%20like%20to%20inquire%20about%20membership" target="_blank" class="btn-red px-8 py-3 font-bold text-sm tracking-widest shadow-md inline-flex items-center gap-2">
            <i class="fa-brands fa-whatsapp"></i> BOOK A SESSION VIA WHATSAPP
          </a>
        </div>
      </div>
    </div>
  </section>
  
</main>
@endsection
