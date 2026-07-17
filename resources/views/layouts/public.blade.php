<!DOCTYPE html>
<html lang="en" x-data="app()" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <!-- ===== SEO: Primary ===== -->
  <title>@yield('seo_title', 'Kona Fight Camp — Muay Thai, Boxing &amp; Conditioning · Bali')</title>
  <meta name="description" content="@yield('meta_description', 'Train Muay Thai, Boxing &amp; Conditioning at Kona Fight Camp in North Canggu, Bali. Authentic training with coaches who have 20+ years experience. All levels welcome — beginners to professional fighters.')"/>
  <meta name="keywords" content="@yield('meta_keywords', 'Muay Thai Bali, boxing Bali, Kona Fight Camp, fight camp Canggu, Muay Thai training Bali, martial arts Bali, kickboxing Bali')"/>
  <meta name="robots" content="index, follow"/>
  <meta name="author" content="Kona Fight Camp"/>
  <link rel="canonical" href="{{ url()->current() }}"/>

  <!-- ===== SEO: Open Graph / Facebook ===== -->
  <meta property="og:type" content="website"/>
  <meta property="og:site_name" content="Kona Fight Camp"/>
  <meta property="og:locale" content="en_US"/>
  <meta property="og:url" content="{{ url()->current() }}"/>
  <meta property="og:title" content="@yield('og_title', 'Kona Fight Camp — Muay Thai, Boxing &amp; Conditioning · Bali')"/>
  <meta property="og:description" content="@yield('og_description', 'Authentic Muay Thai, Boxing &amp; Conditioning in North Canggu, Bali. Built from real experience — 20+ years. All levels welcome.')"/>
  <meta property="og:image" content="{{ asset('img/logo.png') }}"/>
  <meta property="og:image:alt" content="Kona Fight Camp Logo"/>

  <!-- ===== SEO: Twitter Card ===== -->
  <meta name="twitter:card" content="summary_large_image"/>
  <meta name="twitter:title" content="@yield('og_title', 'Kona Fight Camp — Muay Thai, Boxing &amp; Conditioning · Bali')"/>
  <meta name="twitter:description" content="@yield('og_description', 'Authentic Muay Thai, Boxing &amp; Conditioning in North Canggu, Bali. All levels welcome.')"/>
  <meta name="twitter:image" content="{{ asset('img/logo.png') }}"/>
  <meta name="twitter:image:alt" content="Kona Fight Camp Logo"/>

  <!-- ===== Favicons ===== -->
  <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}"/>
  <link rel="apple-touch-icon" href="{{ asset('img/logo.png') }}"/>
  <script>
    // Apply the saved theme before first paint to avoid a flash of the wrong theme.
    (function () {
      try {
        var stored = localStorage.getItem('theme');
        document.documentElement.classList.toggle('dark', stored ? stored === 'dark' : true);
      } catch (e) {
        document.documentElement.classList.add('dark');
      }
    })();
  </script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet"/>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
          colors: {
            brand: { red: '#E5122B', dark: '#0A0A0A', card: '#111111', border: '#1E1E1E' }
          }
        }
      }
    }
  </script>
  <style>
    *, *::before, *::after { border-radius: 0 !important; box-sizing: border-box; }
    html { font-family: 'Plus Jakarta Sans', sans-serif; }
    :root { --red: #E5122B; }
    .nav-link { position: relative; }
    .nav-link::after { content:''; position:absolute; left:0; bottom:-4px; width:0; height:2px; background:var(--red); transition:width .3s ease; }
    .nav-link:hover::after, .nav-link.active::after { width:100%; }
    .section-border-bottom { border-bottom: 3px solid var(--red); }
    .btn-red { background:var(--red); color:#fff; transition: opacity .2s, transform .15s; cursor:pointer; }
    .btn-red:hover { opacity:.88; transform:translateY(-1px); }
    .btn-outline { border: 2px solid var(--red); color:var(--red); background:transparent; transition: background .2s, color .2s, transform .15s; cursor:pointer; }
    .btn-outline:hover { background:var(--red); color:#fff; transform:translateY(-1px); }
    .btn-dark { background:#111; color:#fff; border:2px solid #333; transition: border-color .2s, transform .15s; cursor:pointer; }
    .btn-dark:hover { border-color:var(--red); transform:translateY(-1px); }
    a, button, [role="button"] { cursor:pointer; }
    .card-hover { transition: transform .2s, box-shadow .2s; }
    .card-hover:hover { transform:translateY(-3px); box-shadow: 0 8px 30px rgba(229,18,43,.15); }
    .price-card { border-left: 3px solid var(--red); }
    .highlight-row { background: rgba(229,18,43,.07); }
    /* fade-up: animation disabled — elements always visible */
    .fade-up { opacity:1; transform:none; }
    /* Nav shrink */
    nav.scrolled { box-shadow: 0 4px 24px rgba(0,0,0,.5); }
    /* Custom scrollbar */
    ::-webkit-scrollbar { width:6px; } ::-webkit-scrollbar-track { background:#111; } ::-webkit-scrollbar-thumb { background:#E5122B; }
    /* Hamburger transition */
    .mobile-menu { max-height:0; overflow:hidden; transition:max-height .35s ease; }
    .mobile-menu.open { max-height:500px; }
    /* Filter tab active */
    .tab-btn.active { background:var(--red); color:#fff; border-color:var(--red); }
    /* Google translate hide banner */
    .goog-te-banner-frame, .goog-te-gadget-icon { display:none !important; }
    body { top: 0 !important; }
    .goog-te-gadget { color: transparent !important; }
    .goog-te-gadget select { color: #fff; background: #111; border:1px solid #333; padding:4px 8px; font-family: 'Plus Jakarta Sans', sans-serif; font-size:.8rem; cursor:pointer; }
    /* Section heading accent */
    .section-heading span { border-bottom:3px solid var(--red); padding-bottom:4px; }
    /* Hero overlay */
    .hero-overlay { background: linear-gradient(to bottom, rgba(0,0,0,.55) 0%, rgba(0,0,0,.82) 100%); z-index:1; }
    /* Hero background slideshow + zoom in/out (Ken Burns) */
    .hero-bg { animation: heroZoom 14s ease-in-out infinite; transform-origin: center; will-change: transform, opacity; }
    @keyframes heroZoom { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.12); } }
    @media (prefers-reduced-motion: reduce) { .hero-bg { animation: none; } }
    /* ==============================================
       LIGHT MODE — complete color system overrides
       ============================================== */

    /* Base */
    html:not(.dark) body { background:#f5f5f5; color:#111; }

    /* Navbar */
    html:not(.dark) nav { background:#fff !important; border-bottom:1px solid #e5e5e5; }

    /* ── Backgrounds ── */
    html:not(.dark) .bg-brand-dark   { background:#f5f5f5 !important; }
    html:not(.dark) .bg-brand-card   { background:#f0f0f0 !important; }
    html:not(.dark) .bg-\[#0a0a0a\] { background:#ebebeb !important; }
    html:not(.dark) .bg-\[#111111\] { background:#e4e4e4 !important; }
    /* ── Borders ── */
    html:not(.dark) .border-brand-border { border-color:#d4d4d4 !important; }

    /* ── Text — general overrides ── */
    html:not(.dark) .text-white   { color:#111 !important; }
    html:not(.dark) .text-gray-200 { color:#333 !important; }
    html:not(.dark) .text-gray-300 { color:#444 !important; }
    html:not(.dark) .text-gray-400 { color:#555 !important; }
    html:not(.dark) .text-gray-500 { color:#666 !important; }
    html:not(.dark) .text-gray-600 { color:#555 !important; }

    /* ── Buttons ── */
    html:not(.dark) .btn-dark       { background:#e8e8e8; color:#111; border-color:#bbb; }
    html:not(.dark) .btn-dark:hover { border-color:var(--red); color:#111; }
    html:not(.dark) .price-card     { background:#e4e4e4; }

    /* ── Table thead ── */
    .thead-table                     { background:#1a1a1a; }
    html:not(.dark) .thead-table     { background:#d4d4d4 !important; color:#111 !important; }

    /* ── Scrollbar ── */
    html:not(.dark) ::-webkit-scrollbar-track { background:#f0f0f0; }

    /* ── EXEMPTION: Hero always has a dark overlay — keep text white ── */
    html:not(.dark) #home .text-white  { color:#fff !important; }
    html:not(.dark) #home .text-gray-200 { color:#f0f0f0 !important; }
    html:not(.dark) #home .text-gray-300 { color:#e0e0e0 !important; }
    html:not(.dark) #home .text-gray-400 { color:#ccc   !important; }

    /* ── EXEMPTION: Stats bar (bg-brand-red) — keep white text on red ── */
    html:not(.dark) .bg-brand-red               { color:#fff; }
    html:not(.dark) .bg-brand-red .text-white   { color:#fff !important; }

    /* ── EXEMPTION: Footer — always dark themed ── */
    html:not(.dark) footer                      { background:#111 !important; color:#bbb; }
    html:not(.dark) footer .text-white          { color:#ddd !important; }
    html:not(.dark) footer .text-gray-400,
    html:not(.dark) footer .text-gray-500,
    html:not(.dark) footer .text-gray-600       { color:#999 !important; }
    html:not(.dark) footer .text-brand-red      { color:var(--red) !important; }
    html:not(.dark) footer .border-brand-border { border-color:#333 !important; }
    html:not(.dark) footer a:hover              { color:var(--red) !important; }
  </style>
  <!-- ===== SEO: JSON-LD Structured Data ===== -->
  <script type="application/ld+json">
  {
    "@@context": "https://schema.org",
    "@type": "SportsActivityLocation",
    "name": "Kona Fight Camp",
    "description": "Authentic Muay Thai, Boxing and Conditioning training in North Canggu, Bali, Indonesia. All levels welcome.",
    "url": "{!! url('/') !!}",
    "logo": "{!! asset('img/logo.png') !!}",
    "image": "{!! asset('img/logo.png') !!}",
    "telephone": "+6285119339311",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "North Canggu",
      "addressLocality": "Canggu",
      "addressRegion": "Bali",
      "addressCountry": "ID"
    },
    "geo": {
      "@type": "GeoCoordinates",
      "latitude": -8.616572,
      "longitude": 115.170565
    },
    "openingHoursSpecification": {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
      "opens": "06:00",
      "closes": "21:00"
    },
    "priceRange": "Rp 60.000 - Rp 170.000",
    "sameAs": [
      "https://www.instagram.com/konafightcamp/"
    ],
    "contactPoint": {
      "@type": "ContactPoint",
      "telephone": "+6285119339311",
      "contactType": "customer service",
      "availableLanguage": ["English", "Indonesian"]
    }
  }
  </script>

  @stack('head')
</head>
<body class="bg-brand-dark text-white transition-colors duration-300">

<!-- ===== DISCLAIMER TOPBAR ===== -->
<div x-show="showDisclaimer"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 -translate-y-full"
     class="fixed top-0 left-0 right-0 z-[70] bg-amber-400 text-black py-2 px-10 flex items-center justify-center text-xs font-semibold tracking-wide text-center">
  <i class="fa-solid fa-triangle-exclamation mr-2 flex-shrink-0"></i>
  <span>This website is currently under development. Some features may be incomplete or subject to change.</span>
  <button @click="showDisclaimer = false"
          class="absolute right-4 top-1/2 -translate-y-1/2 text-black hover:opacity-60 transition-opacity cursor-pointer"
          title="Dismiss">
    <i class="fa-solid fa-xmark"></i>
  </button>
</div>

<!-- ===== NAVBAR ===== -->
@php
  $navItems = [
    ['label' => 'HOME',     'route' => 'home'],
    ['label' => 'PRICES',   'route' => 'public.prices'],
    ['label' => 'ABOUT',    'route' => 'public.about'],
    ['label' => 'COACHES',  'route' => 'public.coaches'],
    ['label' => 'GALLERY',  'route' => 'public.gallery'],
    ['label' => 'CONTACT',  'route' => 'public.contact'],
  ];
@endphp
<nav id="navbar" x-data="{ open: false }" class="fixed left-0 right-0 z-50 bg-brand-dark border-b border-brand-border transition-all duration-300" :class="showDisclaimer ? 'top-9' : 'top-0'">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">
      <!-- Logo -->
      <a href="{{ route('home') }}" class="flex items-center gap-3 cursor-pointer">
        <img src="{{ asset('img/logo.png') }}" alt="Kona Fight Camp Logo" class="h-18 w-14 object-cover shadow-md"/>
        <span class="font-extrabold text-lg tracking-tight text-white"><span class="text-brand-red">KONA</span> FIGHT CAMP</span>
      </a>
      <!-- Desktop Nav -->
      <div class="hidden md:flex items-center gap-7 text-sm font-semibold tracking-wide">
        @foreach ($navItems as $item)
          <a href="{{ route($item['route']) }}" class="nav-link text-white hover:text-brand-red transition-colors {{ request()->routeIs($item['route']) ? 'active text-brand-red' : '' }}">{{ $item['label'] }}</a>
        @endforeach
      </div>
      <!-- Right Controls -->
      <div class="hidden md:flex items-center gap-3">
        <!-- Dark/Light toggle -->
        <button @click="darkMode = !darkMode" class="btn-dark p-2 shadow-md text-sm" :title="darkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'">
          <i :class="darkMode ? 'fa-solid fa-sun text-yellow-400' : 'fa-solid fa-moon text-blue-400'"></i>
        </button>
        @auth
          <a href="{{ route('dashboard') }}" class="btn-red px-4 py-2 text-xs font-bold shadow-md flex items-center gap-2">
            <i class="fa-solid fa-gauge-high"></i> DASHBOARD
          </a>
        @else
          <a href="{{ route('login') }}" class="btn-dark px-4 py-2 text-xs font-bold shadow-md flex items-center gap-2">
            <i class="fa-solid fa-right-to-bracket"></i> LOGIN
          </a>
          <a href="{{ route('register') }}" class="btn-red px-4 py-2 text-xs font-bold shadow-md flex items-center gap-2">
            <i class="fa-solid fa-user-plus"></i> JOIN NOW
          </a>
        @endauth
      </div>
      <!-- Hamburger -->
      <button @click="open = !open" class="md:hidden text-white text-xl p-2 cursor-pointer">
        <i :class="open ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'"></i>
      </button>
    </div>
  </div>
  <!-- Mobile Menu -->
  <div :class="open ? 'open' : ''" class="mobile-menu md:hidden bg-brand-dark border-t border-brand-border px-4">
    <div class="flex flex-col py-3 gap-3 text-sm font-semibold">
      @foreach ($navItems as $item)
        <a @click="open=false" href="{{ route($item['route']) }}" class="py-2 border-b border-brand-border text-white hover:text-brand-red transition-colors {{ request()->routeIs($item['route']) ? 'text-brand-red' : '' }}">{{ $item['label'] }}</a>
      @endforeach
      <div class="flex items-center gap-3 pt-2">
        <div id="google_translate_element_mobile" class="text-xs"></div>
        <button @click="darkMode = !darkMode" class="btn-dark p-2 text-sm shadow-md">
          <i :class="darkMode ? 'fa-solid fa-sun text-yellow-400' : 'fa-solid fa-moon text-blue-400'"></i>
        </button>
        @auth
          <a @click="open=false" href="{{ route('dashboard') }}" class="btn-red px-4 py-2 text-xs font-bold shadow-md flex items-center gap-2">
            <i class="fa-solid fa-gauge-high"></i> DASHBOARD
          </a>
        @else
          <a @click="open=false" href="{{ route('login') }}" class="btn-dark px-4 py-2 text-xs font-bold shadow-md flex items-center gap-2">
            <i class="fa-solid fa-right-to-bracket"></i> LOGIN
          </a>
          <a @click="open=false" href="{{ route('register') }}" class="btn-red px-4 py-2 text-xs font-bold shadow-md flex items-center gap-2">
            <i class="fa-solid fa-user-plus"></i> JOIN NOW
          </a>
        @endauth
      </div>
    </div>
  </div>
</nav>

@yield('content')

<!-- ===== FOOTER ===== -->
<footer class="bg-[#050505] border-t border-brand-border py-10">
  <div class="max-w-7xl mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
      <div>
        <div class="flex items-center gap-3 mb-4">
          <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-10 w-10 object-cover"/>
          <span class="font-extrabold text-lg text-white"><span class="text-brand-red">KONA</span> FIGHT CAMP</span>
        </div>
        <p class="text-gray-500 text-sm leading-relaxed">Muay Thai • Boxing • Conditioning. Authentic. Affordable. Serious training.<br/><span class="inline-flex items-center gap-1 mt-2"><i class="fa-solid fa-location-dot text-brand-red"></i> North Canggu, Bali</span></p>
      </div>
      <div>
        <div class="text-white font-bold text-xs tracking-widest mb-4 section-border-bottom pb-2">QUICK LINKS</div>
        <ul class="space-y-2 text-sm text-gray-400">
          <li><a href="{{ route('home') }}" class="hover:text-brand-red transition-colors cursor-pointer">Home</a></li>
          <li><a href="{{ route('public.prices') }}" class="hover:text-brand-red transition-colors cursor-pointer">Prices</a></li>
          <li><a href="{{ route('public.about') }}" class="hover:text-brand-red transition-colors cursor-pointer">About</a></li>
          <li><a href="{{ route('public.gallery') }}" class="hover:text-brand-red transition-colors cursor-pointer">Gallery</a></li>
          <li><a href="{{ route('public.contact') }}" class="hover:text-brand-red transition-colors cursor-pointer">Contact</a></li>
        </ul>
      </div>
      <div>
        <div class="text-white font-bold text-xs tracking-widest mb-4 section-border-bottom pb-2">FOLLOW US</div>
        <div class="flex gap-4">
          <a href="https://www.instagram.com/konafightcamp/" target="_blank" class="w-10 h-10 bg-[#111111] border border-brand-border flex items-center justify-center text-gray-400 hover:text-brand-red hover:border-brand-red transition-colors shadow-md cursor-pointer">
            <i class="fa-brands fa-instagram"></i>
          </a>
          <a href="https://wa.me/6285119339311" target="_blank" class="w-10 h-10 bg-[#111111] border border-brand-border flex items-center justify-center text-gray-400 hover:text-brand-red hover:border-brand-red transition-colors shadow-md cursor-pointer">
            <i class="fa-brands fa-whatsapp"></i>
          </a>
        </div>
      </div>
    </div>
    <div class="border-t border-brand-border pt-6 text-center text-gray-600 text-xs">
      &copy; 2025 Kona Fight Camp. All rights reserved.
    </div>
  </div>
</footer>

<!-- ===== FLOATING BUTTONS ===== -->
<!-- WhatsApp FAB -->
{{-- 6285119339311 --}}
<a href="https://wa.me/6285119339311?text=Hi%20Kona%20Fight%20Camp!" target="_blank"
   class="fixed bottom-20 right-5 z-50 w-12 h-12 bg-green-600 flex items-center justify-center text-white text-xl shadow-md hover:bg-green-500 transition-colors cursor-pointer" title="Chat on WhatsApp">
  <i class="fa-brands fa-whatsapp"></i>
</a>
<!-- Back to Top -->
<button id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})"
  class="fixed bottom-5 right-5 z-50 w-12 h-12 btn-red flex items-center justify-center text-white text-lg shadow-md opacity-0 transition-opacity duration-300 cursor-pointer" title="Back to Top">
  <i class="fa-solid fa-chevron-up"></i>
</button>

<!-- Google Translate Script -->
<script>
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'en',
    includedLanguages: 'en,id',
    layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
    autoDisplay: false
  }, 'google_translate_element');
  new google.translate.TranslateElement({
    pageLanguage: 'en',
    includedLanguages: 'en,id',
    layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
    autoDisplay: false
  }, 'google_translate_element_mobile');
}
</script>
<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

<script>
  function app() {
    return {
      darkMode: document.documentElement.classList.contains('dark'),
      showDisclaimer: true,
      init() {
        // Keep the <html> class in sync and remember the choice across visits.
        this.$watch('darkMode', (value) => {
          document.documentElement.classList.toggle('dark', value);
          try { localStorage.setItem('theme', value ? 'dark' : 'light'); } catch (e) {}
        });
      },
    }
  }

  // Navbar shrink + back to top
  const navbar = document.getElementById('navbar');
  const backTop = document.getElementById('backToTop');
  window.addEventListener('scroll', () => {
    if(window.scrollY > 60) { navbar.classList.add('scrolled'); backTop.style.opacity = '1'; }
    else { navbar.classList.remove('scrolled'); backTop.style.opacity = '0'; }
  });
</script>
@stack('scripts')
</body>
</html>
