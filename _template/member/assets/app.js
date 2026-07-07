/* ==========================================================================
   Kona Fight Camp — Member System (prototype)
   Shared Alpine.js data + components.

   NOTE: This is a STATIC front-end prototype. Data is passed between pages
   using localStorage so the flow (register -> payment -> confirm -> done)
   feels connected. When porting to Laravel, replace the localStorage calls
   with real requests/controllers and Blade-rendered data.
   ========================================================================== */

/* ---- Theme (dark/light toggle, persisted) ---- */
function app() {
  return {
    darkMode: localStorage.getItem('kfc_dark') !== 'false',
    init() { this.$watch('darkMode', v => localStorage.setItem('kfc_dark', v)); },
  };
}

/* ---- Helpers ---- */
function formatRp(n) { return 'Rp ' + Number(n || 0).toLocaleString('id-ID'); }
function getReg() { try { return JSON.parse(localStorage.getItem('kfc_registration') || 'null'); } catch (e) { return null; } }

/* ---- Membership plans (mirrors the pricing on the main site) ---- */
const PLANS = {
  tourist: [
    { id: 't-1w', name: '1 Week Unlimited',  price: 700000,   period: '/ week' },
    { id: 't-1m', name: '1 Month Unlimited', price: 1600000,  period: '/ month', popular: true },
    { id: 't-3m', name: '3 Months Unlimited',price: 4200000,  period: '/ 3 months' },
    { id: 't-6m', name: '6 Months Unlimited',price: 7500000,  period: '/ 6 months' },
    { id: 't-1y', name: '1 Year Unlimited',  price: 12000000, period: '/ year', best: true },
  ],
  local: [
    { id: 'l-1w', name: '1 Week Unlimited',  price: 250000,  period: '/ week' },
    { id: 'l-1m', name: '1 Month Unlimited', price: 550000,  period: '/ month', popular: true },
    { id: 'l-3m', name: '3 Months Unlimited',price: 1400000, period: '/ 3 months' },
    { id: 'l-6m', name: '6 Months Unlimited',price: 2500000, period: '/ 6 months' },
    { id: 'l-1y', name: '1 Year Unlimited',  price: 4500000, period: '/ year', best: true },
  ],
};

/* ---- Local Indonesian bank transfer options ---- */
const LOCAL_BANKS = [
  { id: 'bca',     name: 'BCA',          tag: 'Bank Central Asia',   icon: 'fa-solid fa-building-columns',
    fields: [['Account Number', '728 012 3456'], ['Account Name', 'PT Kona Fight Camp Bali']] },
  { id: 'mandiri', name: 'Mandiri',      tag: 'Bank Mandiri',        icon: 'fa-solid fa-building-columns',
    fields: [['Account Number', '145 0099 887 766'], ['Account Name', 'PT Kona Fight Camp Bali']] },
  { id: 'bni',     name: 'BNI',          tag: 'Bank Negara Indonesia', icon: 'fa-solid fa-building-columns',
    fields: [['Account Number', '0998 7766 55'], ['Account Name', 'PT Kona Fight Camp Bali']] },
  { id: 'bri',     name: 'BRI',          tag: 'Bank Rakyat Indonesia', icon: 'fa-solid fa-building-columns',
    fields: [['Account Number', '0123 01 000123 30 7'], ['Account Name', 'PT Kona Fight Camp Bali']] },
  { id: 'qris',    name: 'QRIS',         tag: 'Scan with any e-wallet', icon: 'fa-solid fa-qrcode',
    qr: 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=KONA-FIGHT-CAMP-QRIS', fields: [] },
];

/* ---- International payment options ---- */
const INTL_METHODS = [
  { id: 'paypal', name: 'PayPal',      tag: 'Fast · cards accepted',    icon: 'fa-brands fa-paypal',
    fields: [['PayPal Email', 'payments@konafightcamp.com'], ['PayPal.me', 'paypal.me/konafightcamp']] },
  { id: 'wise',   name: 'Wise',        tag: 'Low fees · multi-currency', icon: 'fa-solid fa-globe',
    fields: [['Account Holder', 'Kona Fight Camp'], ['IBAN', 'BE12 3456 7890 1234'], ['SWIFT / BIC', 'TRWIBEB1XXX']] },
  { id: 'swift',  name: 'SWIFT Wire',  tag: 'International bank wire',    icon: 'fa-solid fa-money-bill-transfer',
    fields: [['Bank', 'Bank Central Asia (BCA)'], ['SWIFT / BIC', 'CENAIDJA'], ['Account Number', '728 012 3456'],
             ['Beneficiary', 'PT Kona Fight Camp Bali'], ['Bank Address', 'Jl. Sunset Road, Kuta, Bali, Indonesia']] },
];

/* ---- Step 1: Registration + plan selection ---- */
function registerForm() {
  return {
    tier: 'tourist',
    plans: PLANS,
    selectedId: null,
    form: { name: '', email: '', phone: '', gender: '', dob: '', address: '', emergency: '', agree: false },
    formatRp,
    init() {
      const existing = getReg();
      if (existing) { this.tier = existing.tier; this.selectedId = existing.plan.id; Object.assign(this.form, existing.member || {}); }
    },
    get currentPlans() { return this.plans[this.tier]; },
    get selected() { return this.currentPlans.find(p => p.id === this.selectedId) || null; },
    setTier(t) { this.tier = t; if (!this.currentPlans.find(p => p.id === this.selectedId)) this.selectedId = null; },
    submit() {
      if (!this.selected) { notify('Please choose a membership plan to continue.', 'Select a plan'); return; }
      if (!this.form.name || !this.form.email || !this.form.phone) { notify('Please complete your name, email and phone number.', 'Missing details'); return; }
      if (!this.form.agree) { notify('Please accept the terms & conditions to continue.', 'One more thing'); return; }
      localStorage.setItem('kfc_registration', JSON.stringify({ tier: this.tier, plan: this.selected, member: this.form, ts: Date.now() }));
      window.location.href = './payment.html';
    },
  };
}

/* ---- Step 2: Payment method + transfer details ---- */
function paymentPage() {
  return {
    reg: null,
    localBanks: LOCAL_BANKS,
    intl: INTL_METHODS,
    method: null,
    copied: '',
    formatRp,
    init() {
      this.reg = getReg();
      if (!this.reg) { window.location.href = './register.html'; return; }
      this.method = LOCAL_BANKS[0];
    },
    select(m) { this.method = m; },
    copy(text, key) {
      navigator.clipboard && navigator.clipboard.writeText(text);
      this.copied = key;
      setTimeout(() => { if (this.copied === key) this.copied = ''; }, 1500);
    },
    proceed() {
      if (this.reg) { this.reg.paymentMethod = this.method.name; localStorage.setItem('kfc_registration', JSON.stringify(this.reg)); }
      window.location.href = './confirmation.html';
    },
  };
}

/* ---- Step 3: Payment confirmation + proof upload ---- */
function confirmationForm() {
  return {
    reg: null,
    fileName: '',
    preview: '',
    form: { sender: '', fromBank: '', amount: '', date: '', note: '' },
    formatRp,
    init() {
      this.reg = getReg();
      if (!this.reg) { window.location.href = './register.html'; return; }
      this.form.amount = this.reg.plan.price;
    },
    onFile(e) {
      const f = e.target.files[0];
      if (!f) return;
      this.fileName = f.name;
      this.preview = f.type.startsWith('image/') ? URL.createObjectURL(f) : '';
    },
    submit() {
      if (!this.form.sender) { notify('Please enter the sender / account name.', 'Missing details'); return; }
      if (!this.fileName) { notify('Please upload your proof of transfer.', 'Proof required'); return; }
      const memberId = 'KFC-' + Math.floor(100000 + Math.random() * 900000);
      this.reg.payment = { ...this.form, proof: this.fileName, ts: Date.now() };
      this.reg.memberId = memberId;
      this.reg.status = 'pending';
      localStorage.setItem('kfc_registration', JSON.stringify(this.reg));
      window.location.href = './success.html';
    },
  };
}

/* ---- Step 4: Success summary ---- */
function successPage() {
  return {
    reg: null,
    formatRp,
    init() {
      this.reg = getReg();
      if (!this.reg) { window.location.href = './register.html'; }
    },
  };
}

/* ---- Login (prototype only) ---- */
function loginForm() {
  return {
    email: '', password: '', show: false,
    submit() {
      if (!this.email || !this.password) { notify('Please enter your email and password.', 'Missing details'); return; }
      window.location.href = './dashboard.html';
    },
  };
}

/* ---- Member dashboard ---- */
function dashboard() {
  return {
    reg: null,
    tab: 'overview',
    formatRp,
    init() { this.reg = getReg(); },
    get memberName() { return this.reg && this.reg.member ? this.reg.member.name : 'Guest Fighter'; },
    get planName() { return this.reg ? this.reg.plan.name : '1 Month Unlimited'; },
    get planPrice() { return this.reg ? this.reg.plan.price : 1600000; },
    get memberId() { return this.reg && this.reg.memberId ? this.reg.memberId : 'KFC-204871'; },
    get status() { return this.reg && this.reg.status ? this.reg.status : 'active'; },
    get validUntil() {
      const d = new Date();
      d.setMonth(d.getMonth() + 1);
      return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
    },
    logout() { window.location.href = './login.html'; },
  };
}

/* ---- Custom modal (replaces the native alert popup) ---- */
document.addEventListener('alpine:init', () => {
  Alpine.store('modal', {
    open: false,
    title: 'Heads up',
    message: '',
    icon: 'fa-circle-exclamation',
    show(message, title, icon) {
      this.message = message;
      this.title = title || 'Heads up';
      this.icon = icon || 'fa-circle-exclamation';
      this.open = true;
    },
    close() { this.open = false; },
  });
});

// Show the custom modal; falls back to native alert only if Alpine isn't ready yet.
function notify(message, title, icon) {
  if (window.Alpine && Alpine.store('modal')) Alpine.store('modal').show(message, title, icon);
  else alert(message);
}

// Inject the modal markup once (before Alpine initialises) so every page shares it.
function mountModal() {
  if (document.getElementById('app-modal')) return;
  const el = document.createElement('div');
  el.id = 'app-modal';
  el.setAttribute('x-data', '{}');
  el.setAttribute('x-cloak', '');
  el.innerHTML = [
    '<div x-show="$store.modal.open" x-transition.opacity @keydown.escape.window="$store.modal.close()" class="fixed inset-0 z-[100] flex items-center justify-center px-4">',
    '  <div @click="$store.modal.close()" class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>',
    '  <div x-show="$store.modal.open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-3 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" class="relative bg-brand-card border border-brand-border shadow-2xl w-full max-w-sm">',
    '    <div class="p-6 text-center">',
    '      <div class="w-14 h-14 mx-auto bg-brand-red flex items-center justify-center mb-4"><i :class="\'fa-solid \' + $store.modal.icon" class="text-white text-xl"></i></div>',
    '      <h3 class="text-white font-extrabold text-lg mb-2" x-text="$store.modal.title"></h3>',
    '      <p class="text-gray-400 text-sm leading-relaxed" x-text="$store.modal.message"></p>',
    '    </div>',
    '    <div class="border-t border-brand-border p-4"><button @click="$store.modal.close()" class="btn-red w-full py-2.5 font-bold text-sm tracking-widest shadow-md">OK, GOT IT</button></div>',
    '  </div>',
    '</div>'
  ].join('');
  document.body.appendChild(el);
}
mountModal();

/* ---- Scroll reveal animation (shared) ---- */
document.addEventListener('DOMContentLoaded', () => {
  const obs = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
  }, { threshold: 0.1 });
  document.querySelectorAll('.fade-up').forEach(el => obs.observe(el));
});
