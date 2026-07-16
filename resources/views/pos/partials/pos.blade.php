<!-- POS -->
<div x-show="activeTab === 'pos'" class="flex flex-col lg:grid lg:grid-cols-12 gap-6 lg:h-full">
    <!-- Menu -->
    <div class="lg:col-span-7 bg-white rounded-3xl p-6 flex flex-col">
        <div class="mb-6">
            <h2 class="font-semibold text-xl" x-text="unitInfo[activeUnit].label + ' Menu'"></h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 lg:flex-1 lg:overflow-auto auto-rows-min">
            <template x-if="posItems.length === 0">
                <div class="col-span-2 sm:col-span-3 flex flex-col items-center justify-center text-zinc-300 py-20">
                    <i class="fa-solid fa-box-open text-5xl mb-4"></i>
                    <div class="text-sm">No items available</div>
                </div>
            </template>
            <template x-for="item in posItems" :key="item.id">
                <div @click="addToCart(item)" class="bg-white border rounded-3xl p-4 cursor-pointer hover:border-red-300 transition-colors">
                    <div class="font-medium leading-tight" x-text="item.name"></div>
                    <div class="text-xs text-zinc-400" x-text="item.cat"></div>
                    <div class="mt-6 flex flex-wrap items-center justify-between gap-2">
                        <div class="text-lg font-semibold">
                            <span x-text="formatRp(effPrice(item))"></span>
                            <span x-show="item.hasDiscount" x-cloak class="block text-xs text-zinc-400 line-through font-normal" x-text="formatRp(item.price)"></span>
                        </div>
                        <button @click.stop="addToCart(item)" class="px-5 py-2 bg-red-600 text-white text-xs rounded-2xl flex items-center gap-1"><i class="fa-solid fa-plus"></i> Add</button>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Cart -->
    <div id="cartCard" class="lg:col-span-5 bg-white rounded-3xl p-6 flex flex-col scroll-mt-4">
        <div class="font-semibold mb-6 flex items-center gap-2">
            <span>Cart</span>
            <span x-show="cartCount > 0" x-cloak class="bg-red-600 text-white text-xs font-semibold rounded-full min-w-[1.25rem] h-5 px-1.5 flex items-center justify-center" x-text="cartCount"></span>
        </div>

        <div class="space-y-4 lg:flex-1 lg:overflow-auto">
            <template x-if="cart.length === 0">
                <div class="flex flex-col items-center justify-center text-zinc-300 py-20">
                    <i class="fa-solid fa-cart-shopping text-5xl mb-4"></i>
                    <div class="text-sm">Cart is empty</div>
                </div>
            </template>
            <template x-for="(item, idx) in cart" :key="item.id">
                <div class="flex gap-4 items-center bg-zinc-50 rounded-2xl p-4">
                    <div class="flex-1">
                        <div class="font-medium" x-text="item.name"></div>
                        <div class="text-xs text-zinc-400" x-text="formatRp(item.price)"></div>
                    </div>
                    <div class="flex items-center border rounded-2xl bg-white">
                        <button @click="cartQty(idx, -1)" class="w-8 h-8 flex items-center justify-center" aria-label="Decrease quantity"><i class="fa-solid fa-minus text-xs"></i></button>
                        <div class="px-4 font-medium" x-text="item.qty"></div>
                        <button @click="cartQty(idx, 1)" class="w-8 h-8 flex items-center justify-center" aria-label="Increase quantity"><i class="fa-solid fa-plus text-xs"></i></button>
                    </div>
                    <div class="text-right w-20">
                        <div class="font-semibold" x-text="formatRp(item.price * item.qty)"></div>
                    </div>
                    <button @click="removeCartItem(idx)" class="text-red-300 hover:text-red-500"><i class="fa-solid fa-xmark"></i></button>
                </div>
            </template>
        </div>

        <div class="pt-6 border-t mt-auto">
            <div class="flex justify-between mb-1">
                <span class="text-zinc-500">Subtotal</span>
                <span class="font-medium" x-text="formatRp(subtotal)"></span>
            </div>
            <div class="flex justify-between mb-4">
                <span class="text-zinc-500">Tax (11%)</span>
                <span class="font-medium" x-text="formatRp(tax)"></span>
            </div>
            <div class="flex justify-between text-xl font-semibold border-t pt-4">
                <span>Total</span>
                <span class="text-red-600" x-text="formatRp(total)"></span>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-8">
                <button @click="clearCart()" class="py-5 border border-zinc-300 hover:bg-zinc-50 rounded-3xl text-zinc-500 flex items-center justify-center gap-2"><i class="fa-solid fa-trash-can"></i> Clear</button>
                <button @click="checkout()" class="py-5 bg-red-600 hover:bg-red-700 text-white rounded-3xl font-semibold flex items-center justify-center gap-2"><i class="fa-solid fa-credit-card"></i> Checkout</button>
            </div>
        </div>
    </div>
</div>
