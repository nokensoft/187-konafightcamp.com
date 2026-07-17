@extends('layouts.public')

@section('title', 'Contact')
@section('seo_title', 'Contact — Kona Fight Camp Bali | Get in Touch')
@section('meta_description', 'Contact Kona Fight Camp in North Canggu, Bali. Message us via WhatsApp at +62 851-1933-9311, follow on Instagram @konafightcamp, or find us on Google Maps.')
@section('meta_keywords', 'contact Kona Fight Camp, Kona Fight Camp location Bali, Muay Thai gym Canggu address, fight camp WhatsApp Bali, Kona Fight Camp maps')
@section('og_title', 'Contact — Kona Fight Camp Bali')
@section('og_description', 'Get in touch with Kona Fight Camp. WhatsApp: +62 851-1933-9311. Instagram: @konafightcamp. Located in North Canggu, Bali, Indonesia.')

@section('content')
<main>
  <x-breadcrumb title="CONTACT" current="Contact" />

  
  
  <!-- ===== CONTACT ===== -->
<section id="contact" class="py-20 bg-gray-50 dark:bg-brand-dark transition-colors duration-300">
  <div class="max-w-7xl mx-auto px-4">
    <div class="section-heading mb-12 fade-up">
      <p class="text-brand-red text-xs font-bold tracking-widest mb-2">REACH US</p>
      <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white"><span>GET IN TOUCH</span></h2>
      <div class="w-16 h-1 bg-brand-red mt-3"></div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
      <!-- Info -->
      <div class="fade-up space-y-6">
        <div class="bg-white dark:bg-[#111111] p-6 border border-gray-200 dark:border-brand-border shadow-md flex gap-4 items-start transition-colors duration-300">
          <i class="fa-solid fa-location-dot text-brand-red text-xl mt-1"></i>
          <div>
            <div class="text-gray-900 dark:text-white font-bold mb-1">ADDRESS</div>
            <a href="https://www.google.com/maps/search/?api=1&query=Kona+Fight+Camp+North+Canggu+Bali" target="_blank" class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed hover:text-brand-red dark:hover:text-brand-red transition-colors cursor-pointer">Kona Fight Camp, North Canggu, Bali, Indonesia</a>
          </div>
        </div>
        <div class="bg-white dark:bg-[#111111] p-6 border border-gray-200 dark:border-brand-border shadow-md flex gap-4 items-start transition-colors duration-300">
          <i class="fa-brands fa-instagram text-brand-red text-xl mt-1"></i>
          <div>
            <div class="text-gray-900 dark:text-white font-bold mb-1">INSTAGRAM</div>
            <a href="https://www.instagram.com/konafightcamp/" target="_blank" class="text-brand-red text-sm hover:underline cursor-pointer">@konafightcamp</a>
          </div>
        </div>
        <div class="bg-white dark:bg-[#111111] p-6 border border-gray-200 dark:border-brand-border shadow-md flex gap-4 items-start transition-colors duration-300">
          <i class="fa-brands fa-whatsapp text-brand-red text-xl mt-1"></i>
          <div>
            <div class="text-gray-900 dark:text-white font-bold mb-1">WHATSAPP</div>
            <a href="https://wa.me/6285119339311" target="_blank" class="text-brand-red text-sm hover:underline cursor-pointer">+62 851-1933-9311</a>
          </div>
        </div>
        <a href="https://www.google.com/maps/search/?api=1&query=Kona+Fight+Camp+North+Canggu+Bali" target="_blank" class="block bg-white dark:bg-[#111111] p-6 border border-gray-200 dark:border-brand-border shadow-md card-hover cursor-pointer transition-colors duration-300">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3652.0084249140455!2d115.17056489999999!3d-8.616572699999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd239f0b0afcb57%3A0xfcdb7cfde7279bdd!2sBagoes%20Kitchen%20-%20Coffee%20%26%20Resto!5e1!3m2!1sid!2sid!4v1781681739555!5m2!1sid!2sid" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="rounded"></iframe>
          <div class="text-brand-red text-xs mt-3 text-center font-semibold tracking-widest hover:underline"><i class="fa-solid fa-location-dot mr-1"></i> VIEW ON GOOGLE MAPS — NORTH CANGGU, BALI</div>
        </a>
      </div>
      <!-- Contact Form -->
      <div class="fade-up">
        <div class="bg-white dark:bg-[#111111] p-8 border border-gray-200 dark:border-brand-border shadow-md transition-colors duration-300">
          <h3 class="text-gray-900 dark:text-white font-extrabold text-lg mb-6 section-border-bottom pb-2">SEND US A MESSAGE</h3>
          <div x-data="contactForm()" class="space-y-4">
            <div>
              <label class="text-gray-600 dark:text-gray-400 text-xs font-semibold tracking-widest block mb-2">YOUR NAME</label>
              <input x-model="name" type="text" placeholder="John Doe" class="w-full bg-gray-50 dark:bg-brand-dark border border-gray-200 dark:border-brand-border text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 px-4 py-3 text-sm focus:outline-none focus:border-brand-red transition-all"/>
            </div>
            <div>
              <label class="text-gray-600 dark:text-gray-400 text-xs font-semibold tracking-widest block mb-2">PHONE / EMAIL</label>
              <input x-model="contact" type="text" placeholder="+62 8xx / email@example.com" class="w-full bg-gray-50 dark:bg-brand-dark border border-gray-200 dark:border-brand-border text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 px-4 py-3 text-sm focus:outline-none focus:border-brand-red transition-all"/>
            </div>
            <div>
              <label class="text-gray-600 dark:text-gray-400 text-xs font-semibold tracking-widest block mb-2">MESSAGE</label>
              <textarea x-model="message" rows="4" placeholder="Hi Kona Fight Camp, I'd like to know more about..." class="w-full bg-gray-50 dark:bg-brand-dark border border-gray-200 dark:border-brand-border text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 px-4 py-3 text-sm focus:outline-none focus:border-brand-red transition-all resize-none"></textarea>
            </div>
            <button @click="sendToWhatsApp()" class="btn-red w-full py-3 font-bold text-sm tracking-widest shadow-md flex items-center justify-center gap-2">
              <i class="fa-brands fa-whatsapp"></i> SEND VIA WHATSAPP
            </button>
            <p class="text-gray-500 dark:text-gray-400 text-xs text-center">This will open WhatsApp with your message pre-filled.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


</main>
@endsection

@push('scripts')
<script>
  function contactForm() {
    return {
      name: '',
      contact: '',
      message: '',
      sendToWhatsApp() {
        const text = `Hi Kona Fight Camp!%0A%0AName: ${encodeURIComponent(this.name)}%0AContact: ${encodeURIComponent(this.contact)}%0AMessage: ${encodeURIComponent(this.message)}`;
        window.open(`https://wa.me/6285119339311?text=${text}`, '_blank');
      }
    }
  }
</script>
@endpush
