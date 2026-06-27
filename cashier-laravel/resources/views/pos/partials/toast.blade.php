<!-- Add-to-cart toast -->
<div x-show="toast.show" x-cloak
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 translate-y-4"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 translate-y-0"
     x-transition:leave-end="opacity-0 translate-y-4"
     role="status" aria-live="polite"
     class="fixed left-1/2 -translate-x-1/2 bottom-24 lg:bottom-6 z-[70] w-[calc(100%-2rem)] max-w-sm">
    <div class="bg-zinc-900 text-white rounded-2xl shadow-xl px-4 py-3 flex items-center gap-3">
        <i class="fa-solid fa-circle-check text-emerald-400 text-lg"></i>
        <span class="text-sm flex-1 min-w-0 truncate" x-text="toast.message"></span>
        <button @click="goToCart()" class="shrink-0 text-sm font-semibold text-emerald-400 hover:text-emerald-300 whitespace-nowrap">View Cart</button>
    </div>
</div>

<!-- Mobile quick-access cart button -->
<button x-show="activeTab === 'pos' && cartCount > 0" x-cloak x-transition.opacity
        @click="goToCart()"
        class="lg:hidden fixed bottom-6 right-6 z-[65] w-14 h-14 bg-red-600 hover:bg-red-700 text-white rounded-full shadow-xl flex items-center justify-center"
        aria-label="View cart">
    <i class="fa-solid fa-cart-shopping text-lg"></i>
    <span class="absolute -top-1 -right-1 bg-white text-red-600 text-xs font-bold rounded-full min-w-[1.5rem] h-6 px-1 flex items-center justify-center border-2 border-red-600" x-text="cartCount"></span>
</button>
