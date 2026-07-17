@props(['title', 'current' => null])

{{-- Minimalist breadcrumb: title centered on top, navigation trail centered below.
     Top padding clears the fixed navbar (+ disclaimer topbar). --}}
<header class="pt-28 md:pt-32 pb-10 bg-brand-dark border-b border-brand-border text-center">
  <h1 class="text-4xl md:text-5xl font-extrabold text-white">
    <span class="section-border-bottom pb-1">{{ $title }}</span>
  </h1>
  <nav aria-label="Breadcrumb" class="mt-5 flex items-center justify-center gap-2 text-xs font-semibold tracking-widest text-gray-400">
    <a href="{{ route('home') }}" class="hover:text-brand-red transition-colors">HOME</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-brand-red"></i>
    <span class="text-brand-red">{{ strtoupper($current ?? $title) }}</span>
  </nav>
</header>
