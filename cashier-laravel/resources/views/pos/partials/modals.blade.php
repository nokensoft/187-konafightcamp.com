<!-- ============ MODALS (Alpine + Tailwind) ============ -->

<!-- Register New Member -->
<div x-show="memberModal.open" x-cloak x-transition.opacity
     @click.self="memberModal.open = false" @keydown.escape.window="memberModal.open = false"
     class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-4">
    <div x-show="memberModal.open" x-transition class="bg-white rounded-3xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
        <div class="p-6 sm:p-8">
            <h3 class="text-xl font-semibold mb-6">Register New Member</h3>
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Full Name</label>
                    <input x-model="memberModal.name" placeholder="e.g. Budi Santoso" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-600 mb-2">Gender</label>
                        <select x-model="memberModal.gender" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-600 mb-2">Registration Date</label>
                        <input x-model="memberModal.registrationDate" type="date" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-600 mb-2">Type</label>
                        <select x-model="memberModal.type" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                            <option value="Local">Local / Indonesian</option>
                            <option value="Tourist">Tourist</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-600 mb-2">Membership Package</label>
                        <select x-model="memberModal.package" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                            <template x-for="p in membershipPackages" :key="p">
                                <option x-text="p"></option>
                            </template>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2"
                           x-text="memberModal.type === 'Tourist' ? 'ID Number (Passport)' : 'ID Number (KTP)'"></label>
                    <input x-model="memberModal.idNumber" placeholder="KTP / Passport number" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Address</label>
                    <textarea x-model="memberModal.address" rows="2" placeholder="Street, city, country" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300 resize-none"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Notes</label>
                    <textarea x-model="memberModal.notes" rows="2" placeholder="Additional notes (optional)" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300 resize-none"></textarea>
                </div>
            </div>
            <div class="mt-8 flex gap-4">
                <button @click="memberModal.open = false" class="flex-1 py-5 border rounded-3xl hover:bg-zinc-50 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-xmark"></i> Cancel
                </button>
                <button @click="saveMember()" class="flex-1 py-5 bg-red-600 text-white rounded-3xl hover:bg-red-700 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-user-plus"></i> Save Member
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View Member -->
<div x-show="memberView.open" x-cloak x-transition.opacity
     @click.self="memberView.open = false" @keydown.escape.window="memberView.open = false"
     class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-4">
    <div x-show="memberView.open" x-transition class="bg-white rounded-3xl w-full max-w-md max-h-[90vh] overflow-y-auto">
        <template x-if="memberView.member">
            <div class="p-6 sm:p-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-red-600 text-white rounded-2xl flex items-center justify-center text-lg font-semibold shrink-0"
                         x-text="(memberView.member.name || '?').slice(0, 2).toUpperCase()"></div>
                    <div class="min-w-0">
                        <h3 class="text-xl font-semibold truncate" x-text="memberView.member.name"></h3>
                        <p class="text-zinc-400 text-sm" x-text="memberView.member.id"></p>
                    </div>
                </div>
                <dl class="space-y-4 text-sm">
                    <div class="flex justify-between gap-4"><dt class="text-zinc-400">Gender</dt><dd class="font-medium text-right" x-text="memberView.member.gender || '\u2014'"></dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-zinc-400">Type</dt><dd class="font-medium text-right" x-text="memberView.member.type || '\u2014'"></dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-zinc-400">Package</dt><dd class="font-medium text-right" x-text="memberView.member.package || '\u2014'"></dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-zinc-400">ID Number</dt><dd class="font-medium text-right" x-text="memberView.member.idNumber || '\u2014'"></dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-zinc-400">Registered</dt><dd class="font-medium text-right" x-text="memberView.member.registrationDate || '\u2014'"></dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-zinc-400">Expires</dt><dd class="font-medium text-right" x-text="memberView.member.expiry || '\u2014'"></dd></div>
                    <div>
                        <dt class="text-zinc-400 mb-1">Address</dt>
                        <dd class="font-medium" x-text="memberView.member.address || '\u2014'"></dd>
                    </div>
                    <div>
                        <dt class="text-zinc-400 mb-1">Notes</dt>
                        <dd class="font-medium" x-text="memberView.member.notes || '\u2014'"></dd>
                    </div>
                </dl>
                <div class="mt-8">
                    <button @click="memberView.open = false" class="w-full py-4 bg-zinc-900 text-white rounded-3xl hover:bg-zinc-800 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-xmark"></i> Close
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>

<!-- New / Edit Item -->
<div x-show="itemModal.open" x-cloak x-transition.opacity
     @click.self="itemModal.open = false" @keydown.escape.window="itemModal.open = false"
     class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-4">
    <div x-show="itemModal.open" x-transition class="bg-white rounded-3xl w-full max-w-md max-h-[90vh] overflow-y-auto">
        <div class="p-6 sm:p-8">
            <h3 class="font-semibold text-xl mb-6" x-text="(itemModal.editingId ? 'Edit ' : 'New ') + itemNoun"></h3>
            <div class="space-y-4">
                <input x-model="itemModal.name" class="block w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300" placeholder="Name">
                <input x-model.number="itemModal.price" type="number" class="block w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300" placeholder="Price">
                <select x-model="itemModal.cat" class="block w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                    <template x-for="c in unitCategories" :key="c.name">
                        <option :value="c.name" x-text="c.name"></option>
                    </template>
                </select>
                <input x-model.number="itemModal.stock" type="number" class="block w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300" placeholder="Stock">
            </div>
            <div class="mt-8 flex gap-4">
                <button @click="itemModal.open = false" class="flex-1 py-5 border rounded-3xl hover:bg-zinc-50 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-xmark"></i> Cancel
                </button>
                <button @click="saveItem()" class="flex-1 py-5 bg-red-600 text-white rounded-3xl hover:bg-red-700 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> <span x-text="itemModal.editingId ? 'Save Changes' : 'Add to Catalog'"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- New / Edit Category -->
<div x-show="categoryModal.open" x-cloak x-transition.opacity
     @click.self="categoryModal.open = false" @keydown.escape.window="categoryModal.open = false"
     class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-4">
    <div x-show="categoryModal.open" x-transition class="bg-white rounded-3xl w-full max-w-md max-h-[90vh] overflow-y-auto">
        <div class="p-6 sm:p-8">
            <h3 class="font-semibold text-xl mb-6" x-text="categoryModal.editingName ? 'Edit Category' : 'New Category'"></h3>
            <input x-model="categoryModal.name" @keydown.enter="saveCategory()" class="block w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300" placeholder="Category name">
            <input x-model="categoryModal.description" @keydown.enter="saveCategory()" class="block w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300 mt-4" placeholder="Category description">
            <div class="mt-8 flex gap-4">
                <button @click="categoryModal.open = false" class="flex-1 py-5 border rounded-3xl hover:bg-zinc-50 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-xmark"></i> Cancel
                </button>
                <button @click="saveCategory()" class="flex-1 py-5 bg-red-600 text-white rounded-3xl hover:bg-red-700 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> <span x-text="categoryModal.editingName ? 'Save Changes' : 'Add Category'"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete confirmation (soft-delete to Trash) -->
<div x-show="confirmModal.open" x-cloak x-transition.opacity
     @click.self="confirmModal.open = false" @keydown.escape.window="confirmModal.open = false"
     class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-4">
    <div x-show="confirmModal.open" x-transition class="bg-white rounded-3xl w-full max-w-sm max-h-[90vh] overflow-y-auto">
        <div class="p-6 sm:p-8 text-center">
            <div class="w-14 h-14 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-5 text-2xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="font-semibold text-xl mb-2" x-text="confirmModal.title"></h3>
            <p class="text-zinc-500 mb-8" x-text="confirmModal.message"></p>
            <div class="flex gap-4">
                <button @click="confirmModal.open = false" class="flex-1 py-4 border rounded-3xl hover:bg-zinc-50 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-xmark"></i> Cancel
                </button>
                <button @click="confirmDelete()" class="flex-1 py-4 bg-red-600 text-white rounded-3xl hover:bg-red-700 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-trash-can"></i> Move to Trash
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Checkout success / Receipt -->
<div x-show="checkoutModal.open" x-cloak x-transition.opacity
     @click.self="checkoutModal.open = false" @keydown.escape.window="checkoutModal.open = false"
     class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-4">
    <div x-show="checkoutModal.open" x-transition class="bg-white rounded-3xl w-full max-w-sm max-h-[90vh] overflow-y-auto">
        <div class="p-6 sm:p-8">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                    <i class="fa-solid fa-check"></i>
                </div>
                <h3 class="font-semibold text-2xl">Payment Successful</h3>
                <p class="text-zinc-400 text-sm mt-1">Receipt ready to download &amp; scan</p>
            </div>

            <!-- Receipt (area captured for download) -->
            <div id="receiptContent" class="bg-white border border-zinc-200 rounded-2xl p-6 text-sm">
                <div class="text-center border-b border-dashed border-zinc-300 pb-4 mb-4">
                    <div class="font-bold text-lg tracking-tight">KONA FIGHT CAMP</div>
                    <div class="text-zinc-400 text-xs">Muay Thai &amp; Boxing • Multi-Unit POS</div>
                    <div class="text-zinc-500 text-xs mt-1">
                        <span x-text="receipt.unit"></span> • <span x-text="receipt.date + ' ' + receipt.time"></span>
                    </div>
                </div>

                <div class="flex justify-between text-xs text-zinc-500 mb-3">
                    <span>Receipt No.</span>
                    <span class="font-semibold text-zinc-700" x-text="receipt.ref"></span>
                </div>

                <div class="space-y-2 border-b border-dashed border-zinc-300 pb-4 mb-4">
                    <template x-for="(it, i) in receipt.items" :key="i">
                        <div class="flex justify-between gap-3">
                            <div class="min-w-0">
                                <div class="truncate" x-text="it.name"></div>
                                <div class="text-xs text-zinc-400" x-text="it.qty + ' × ' + formatRp(it.price)"></div>
                            </div>
                            <div class="font-medium whitespace-nowrap" x-text="formatRp(it.lineTotal)"></div>
                        </div>
                    </template>
                </div>

                <div class="space-y-1">
                    <div class="flex justify-between text-zinc-500"><span>Subtotal</span><span x-text="formatRp(receipt.subtotal)"></span></div>
                    <div class="flex justify-between text-zinc-500"><span>Tax (11%)</span><span x-text="formatRp(receipt.tax)"></span></div>
                    <div class="flex justify-between font-semibold text-base border-t border-zinc-200 mt-2 pt-2">
                        <span>Total</span><span class="text-red-600" x-text="formatRp(receipt.total)"></span>
                    </div>
                </div>

                <div class="flex flex-col items-center mt-5 pt-4 border-t border-dashed border-zinc-300">
                    <img :src="receiptQrUrl" x-show="receiptQrUrl" alt="Receipt QR" class="w-32 h-32">
                    <div x-show="!receiptQrUrl" class="w-32 h-32 flex items-center justify-center text-zinc-300 text-xs text-center">QR not available</div>
                    <div class="text-[10px] text-zinc-400 mt-2 tracking-widest">SCAN TO VERIFY RECEIPT</div>
                </div>

                <div class="text-center text-xs text-zinc-400 mt-4">Thank you for your visit</div>
            </div>

            <div class="grid grid-cols-2 gap-3 mt-6">
                <button @click="downloadReceipt()" class="py-4 border border-zinc-300 rounded-3xl hover:bg-zinc-50 flex items-center justify-center gap-2 font-medium">
                    <i class="fa-solid fa-download"></i> Download
                </button>
                <button @click="checkoutModal.open = false" class="py-4 bg-zinc-900 text-white rounded-3xl hover:bg-zinc-800 font-medium flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check"></i> Done
                </button>
            </div>
        </div>
    </div>
</div>
