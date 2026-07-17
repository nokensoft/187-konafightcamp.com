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
  <section id="prices" class="py-20 bg-[#0a0a0a]">
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
            <i class="fa-solid fa-globe mr-2"></i>TOURIST PRICES
          </button>
          <button @click="tab='local'" :class="tab==='local' ? 'active' : ''" class="tab-btn btn-outline px-6 py-2 text-xs font-bold tracking-widest shadow-md transition-all">
            <i class="fa-solid fa-flag mr-2"></i>INDONESIAN LOCAL
          </button>
        </div>

        <!-- TOURIST PRICES -->
        <div x-show="tab==='tourist'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Drop-in Sessions -->
            <div class="price-card bg-[#111111] p-6 shadow-md card-hover border border-brand-border">
              <div class="text-brand-red text-xs font-bold tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-dumbbell"></i> DROP-IN SESSIONS</div>
              <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-brand-border">
                  <div><div class="font-semibold text-white text-sm">Half Session (1hr)</div><div class="text-gray-400 text-xs">Technique · Bag work · Pad work</div></div>
                  <div class="text-brand-red font-bold text-sm">Rp 130K</div>
                </div>
                <div class="flex justify-between items-center py-2 highlight-row px-2">
                  <div><div class="font-semibold text-white text-sm">Full Session (2hr)</div><div class="text-gray-400 text-xs">Sparring · Clinching · Technique · Pads</div></div>
                  <div class="text-brand-red font-bold text-sm">Rp 170K</div>
                </div>
              </div>
            </div>

            <!-- Packages -->
            <div class="price-card bg-[#111111] p-6 shadow-md card-hover border border-brand-border">
              <div class="text-brand-red text-xs font-bold tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-ticket"></i> SESSION PACKAGES</div>
              <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-brand-border">
                  <span class="text-white text-sm font-medium">5 Sessions (1hr)</span>
                  <span class="text-brand-red font-bold text-sm">Rp 600K</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-brand-border highlight-row px-2">
                  <span class="text-white text-sm font-medium">5 Sessions (2hr)</span>
                  <span class="text-brand-red font-bold text-sm">Rp 850K</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-brand-border">
                  <span class="text-white text-sm font-medium">10 Sessions (1hr)</span>
                  <span class="text-brand-red font-bold text-sm">Rp 1,000K</span>
                </div>
                <div class="flex justify-between items-center py-2 highlight-row px-2">
                  <span class="text-white text-sm font-medium">10 Sessions (2hr)</span>
                  <span class="text-brand-red font-bold text-sm">Rp 1,500K</span>
                </div>
              </div>
            </div>

            <!-- Unlimited -->
            <div class="price-card bg-[#111111] p-6 shadow-md card-hover border border-brand-border">
              <div class="text-brand-red text-xs font-bold tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-infinity"></i> UNLIMITED PACKAGES</div>
              <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-brand-border">
                  <span class="text-white text-sm font-medium">1 Week</span>
                  <span class="text-brand-red font-bold text-sm">Rp 700K</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-brand-border highlight-row px-2">
                  <span class="text-white text-sm font-medium">2 Weeks</span>
                  <span class="text-brand-red font-bold text-sm">Rp 1,200K</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-brand-border">
                  <span class="text-white text-sm font-medium">1 Month</span>
                  <span class="text-brand-red font-bold text-sm">Rp 1,600K</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-brand-border highlight-row px-2">
                  <span class="text-white text-sm font-medium">3 Months</span>
                  <span class="text-brand-red font-bold text-sm">Rp 4,200K</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-brand-border">
                  <span class="text-white text-sm font-medium">6 Months</span>
                  <span class="text-brand-red font-bold text-sm">Rp 7,500K</span>
                </div>
                <div class="flex justify-between items-center py-2 highlight-row px-2">
                  <span class="text-white text-sm font-medium">1 Year</span>
                  <span class="text-brand-red font-bold text-sm">Rp 12,000K</span>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- LOCAL PRICES -->
        <div x-show="tab==='local'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="price-card bg-[#111111] p-6 shadow-md card-hover border border-brand-border">
              <div class="text-brand-red text-xs font-bold tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-dumbbell"></i> DROP-IN SESSIONS</div>
              <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-brand-border">
                  <div><div class="font-semibold text-white text-sm">Half Session (1hr)</div></div>
                  <div class="text-brand-red font-bold text-sm">Rp 60K</div>
                </div>
                <div class="flex justify-between items-center py-2 highlight-row px-2">
                  <div><div class="font-semibold text-white text-sm">Full Session (2hr)</div></div>
                  <div class="text-brand-red font-bold text-sm">Rp 90K</div>
                </div>
              </div>
            </div>

            <div class="price-card bg-[#111111] p-6 shadow-md card-hover border border-brand-border">
              <div class="text-brand-red text-xs font-bold tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-ticket"></i> SESSION PACKAGES</div>
              <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-brand-border">
                  <span class="text-white text-sm font-medium">5 Sessions (1hr)</span>
                  <span class="text-brand-red font-bold text-sm">Rp 275K</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-brand-border highlight-row px-2">
                  <span class="text-white text-sm font-medium">5 Sessions (2hr)</span>
                  <span class="text-brand-red font-bold text-sm">Rp 400K</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-brand-border">
                  <span class="text-white text-sm font-medium">10 Sessions (1hr)</span>
                  <span class="text-brand-red font-bold text-sm">Rp 500K</span>
                </div>
                <div class="flex justify-between items-center py-2 highlight-row px-2">
                  <span class="text-white text-sm font-medium">10 Sessions (2hr)</span>
                  <span class="text-brand-red font-bold text-sm">Rp 750K</span>
                </div>
              </div>
            </div>

            <div class="price-card bg-[#111111] p-6 shadow-md card-hover border border-brand-border">
              <div class="text-brand-red text-xs font-bold tracking-widest mb-4 flex items-center gap-2"><i class="fa-solid fa-infinity"></i> UNLIMITED PACKAGES</div>
              <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-brand-border">
                  <span class="text-white text-sm font-medium">1 Week</span>
                  <span class="text-brand-red font-bold text-sm">Rp 250K</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-brand-border highlight-row px-2">
                  <span class="text-white text-sm font-medium">1 Month</span>
                  <span class="text-brand-red font-bold text-sm">Rp 550K</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-brand-border">
                  <span class="text-white text-sm font-medium">3 Months</span>
                  <span class="text-brand-red font-bold text-sm">Rp 1,400K</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-brand-border highlight-row px-2">
                  <span class="text-white text-sm font-medium">6 Months</span>
                  <span class="text-brand-red font-bold text-sm">Rp 2,500K</span>
                </div>
                <div class="flex justify-between items-center py-2 highlight-row px-2">
                  <span class="text-white text-sm font-medium">1 Year</span>
                  <span class="text-brand-red font-bold text-sm">Rp 4,500K</span>
                </div>
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
