<!-- ============ MODALS (Alpine + Tailwind) ============ -->

<!-- Register New Member (manager: creates a login account + gym profile) -->
<div x-show="memberModal.open" x-cloak x-transition.opacity
     @click.self="memberModal.open = false" @keydown.escape.window="memberModal.open = false"
     class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-4">
    <div x-show="memberModal.open" x-transition class="bg-white rounded-3xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 sm:p-8">
            <h3 class="text-xl font-semibold mb-1">Register New Member</h3>
            <p class="text-sm text-zinc-400 mb-6">Creates a member login (email &amp; password) and gym profile.</p>

            <!-- Validation errors -->
            <div x-show="memberModal.errors.length" x-cloak class="mb-5 bg-red-50 border border-red-100 text-red-700 rounded-2xl px-5 py-4 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    <template x-for="(msg, i) in memberModal.errors" :key="i">
                        <li x-text="msg"></li>
                    </template>
                </ul>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Full Name *</label>
                    <input x-model="memberModal.name" placeholder="e.g. Budi Santoso" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                </div>

                <!-- Auth info -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-600 mb-2">Email *</label>
                        <input x-model="memberModal.email" type="email" placeholder="member@example.com" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-600 mb-2">Password *</label>
                        <input x-model="memberModal.password" type="password" autocomplete="new-password" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-600 mb-2">Confirm *</label>
                        <input x-model="memberModal.password_confirmation" type="password" autocomplete="new-password" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-600 mb-2">Phone / WhatsApp *</label>
                        <input x-model="memberModal.phone" placeholder="e.g. 62812xxxxxxx" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-600 mb-2">Date of Birth</label>
                        <input x-model="memberModal.dateOfBirth" type="date" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-600 mb-2">Gender *</label>
                        <select x-model="memberModal.gender" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-600 mb-2">Type *</label>
                        <select x-model="memberModal.type" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                            <option value="Local">Local / Indonesian</option>
                            <option value="Tourist">Tourist</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-600 mb-2">Membership Package</label>
                        <select x-model="memberModal.package" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                            <option value="">— Assign later —</option>
                            <template x-for="p in membershipPackages" :key="p">
                                <option x-text="p"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-600 mb-2"
                               x-text="memberModal.type === 'Tourist' ? 'ID Number (Passport) *' : 'ID Number (KTP) *'"></label>
                        <input x-model="memberModal.idNumber" placeholder="KTP / Passport number" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                    </div>
                </div>

                <!-- KTP / ID Photo upload -->
                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2"
                           x-text="memberModal.type === 'Tourist' ? 'Passport Photo (optional)' : 'KTP / ID Photo (optional)'"></label>

                    <!-- Drop zone (shown when no preview) -->
                    <div x-show="!memberModal.idPhotoPreview"
                         @dragover.prevent="memberModal.idPhotoDragging = true"
                         @dragleave.prevent="memberModal.idPhotoDragging = false"
                         @drop.prevent="memberModal.idPhotoDragging = false; handleIdPhotoFile($event.dataTransfer.files[0])"
                         @click="$refs.idPhotoInput.click()"
                         :class="memberModal.idPhotoDragging ? 'border-red-400 bg-red-50' : 'border-zinc-200 bg-zinc-50 hover:border-red-300 hover:bg-red-50/40'"
                         class="w-full border-2 border-dashed rounded-3xl px-6 py-8 flex flex-col items-center justify-center gap-2 cursor-pointer transition-colors">
                        <i class="fa-solid fa-id-card text-2xl text-zinc-300"></i>
                        <p class="text-sm text-zinc-400 text-center">
                            <span class="font-medium text-zinc-600">Click to upload</span> or drag &amp; drop<br>
                            <span class="text-xs">JPG, PNG, WEBP — max 2 MB</span>
                        </p>
                    </div>

                    <!-- Preview (shown after file selected) -->
                    <div x-show="memberModal.idPhotoPreview" class="relative rounded-3xl overflow-hidden border border-zinc-200">
                        <img :src="memberModal.idPhotoPreview" alt="ID Preview"
                             class="w-full max-h-48 object-cover">
                        <button type="button"
                                @click="clearIdPhoto()"
                                class="absolute top-2 right-2 w-8 h-8 bg-white/90 hover:bg-white text-zinc-600 hover:text-red-600 rounded-full flex items-center justify-center shadow transition">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>

                    <!-- Hidden file input -->
                    <input id="idPhotoInput" x-ref="idPhotoInput" type="file" accept="image/*"
                           class="hidden"
                           @change="handleIdPhotoFile($event.target.files[0])">
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Address</label>
                    <textarea x-model="memberModal.address" rows="2" placeholder="Street, city, country" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300 resize-none"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-600 mb-2">Emergency Contact Name</label>
                        <input x-model="memberModal.emergencyContactName" placeholder="e.g. Siti" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-600 mb-2">Emergency Contact Phone</label>
                        <input x-model="memberModal.emergencyContactPhone" placeholder="e.g. 62812xxxxxxx" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-600 mb-2">Notes</label>
                    <textarea x-model="memberModal.notes" rows="2" placeholder="Additional notes (optional)" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300 resize-none"></textarea>
                </div>
            </div>
            <div class="mt-8 flex gap-4">
                <button @click="memberModal.open = false" :disabled="memberModal.saving" class="flex-1 py-5 border rounded-3xl hover:bg-zinc-50 flex items-center justify-center gap-2 disabled:opacity-50">
                    <i class="fa-solid fa-xmark"></i> Cancel
                </button>
                <button @click="saveMember()" :disabled="memberModal.saving" class="flex-1 py-5 bg-red-600 text-white rounded-3xl hover:bg-red-700 flex items-center justify-center gap-2 disabled:opacity-50">
                    <i class="fa-solid" :class="memberModal.saving ? 'fa-circle-notch fa-spin' : 'fa-user-plus'"></i>
                    <span x-text="memberModal.saving ? 'Saving…' : 'Save Member'"></span>
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

                <!-- Uploaded KTP / ID document (or placeholder) -->
                <div class="mb-6">
                    <div class="text-zinc-400 text-sm mb-2">ID / KTP</div>
                    <template x-if="memberView.member.idPhotoUrl">
                        <a :href="memberView.member.idPhotoUrl" target="_blank" rel="noopener" class="block">
                            <template x-if="!(memberView.member.idPhotoUrl || '').toLowerCase().endsWith('.pdf')">
                                <img :src="memberView.member.idPhotoUrl" alt="ID document" class="w-full max-h-48 rounded-2xl border border-zinc-200 object-contain bg-zinc-50">
                            </template>
                            <template x-if="(memberView.member.idPhotoUrl || '').toLowerCase().endsWith('.pdf')">
                                <div class="flex items-center gap-3 rounded-2xl border border-zinc-200 px-5 py-4 hover:border-red-300 transition">
                                    <i class="fa-solid fa-file-pdf text-2xl text-red-500"></i>
                                    <span class="text-sm font-medium text-zinc-700">View uploaded document</span>
                                </div>
                            </template>
                        </a>
                    </template>
                    <template x-if="!memberView.member.idPhotoUrl">
                        <div class="flex flex-col items-center justify-center gap-2 rounded-2xl border-2 border-dashed border-zinc-200 bg-zinc-50 px-6 py-8 text-center">
                            <i class="fa-solid fa-id-card text-3xl text-zinc-300"></i>
                            <p class="text-sm text-zinc-400">No ID uploaded</p>
                        </div>
                    </template>
                </div>

                <dl class="space-y-4 text-sm">
                    <div class="flex justify-between gap-4"><dt class="text-zinc-400">Gender</dt><dd class="font-medium text-right" x-text="memberView.member.gender || '\u2014'"></dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-zinc-400">Type</dt><dd class="font-medium text-right" x-text="memberView.member.type || '\u2014'"></dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-zinc-400">Package</dt><dd class="font-medium text-right" x-text="memberView.member.package || '\u2014'"></dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-zinc-400">ID Number</dt><dd class="font-medium text-right" x-text="memberView.member.idNumber || '\u2014'"></dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-zinc-400">Registered</dt><dd class="font-medium text-right" x-text="memberView.member.registrationDate || '\u2014'"></dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-zinc-400">Expires</dt><dd class="font-medium text-right" x-text="memberView.member.expiry || '\u2014'"></dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-zinc-400">Status</dt><dd class="font-medium text-right" x-text="memberView.member.verified === false ? (memberView.member.paymentSubmitted ? 'Awaiting verification' : 'Pending') : 'Verified'"></dd></div>
                    <div x-show="memberView.member.paymentProofUrl" x-cloak class="flex justify-between gap-4"><dt class="text-zinc-400">Transfer proof</dt><dd class="text-right"><a :href="memberView.member.paymentProofUrl" target="_blank" rel="noopener" class="text-red-600 underline">View</a></dd></div>
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

<!-- Verify Member (manager/cashier: activate a pending registrant) -->
<div x-show="verifyModal.open" x-cloak x-transition.opacity
     @click.self="verifyModal.open = false" @keydown.escape.window="verifyModal.open = false"
     class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-4">
    <div x-show="verifyModal.open" x-transition class="bg-white rounded-3xl w-full max-w-md max-h-[90vh] overflow-y-auto">
        <template x-if="verifyModal.member">
            <div class="p-6 sm:p-8">
                <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-5 text-2xl">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <h3 class="font-semibold text-xl mb-1 text-center">Verify Member</h3>
                <p class="text-zinc-500 text-sm mb-6 text-center">
                    Activate <span class="font-medium text-zinc-700" x-text="verifyModal.member.name"></span>
                    (<span x-text="verifyModal.member.id"></span>). You can optionally assign a package now.
                </p>

                <!-- Submitted transfer proof (if any) -->
                <div x-show="verifyModal.member.paymentSubmitted" x-cloak class="mb-5 rounded-2xl bg-zinc-50 border border-zinc-100 px-5 py-4 text-sm text-left">
                    <div class="flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <div class="text-zinc-400 text-xs">Transfer proof</div>
                            <div class="font-medium truncate" x-text="verifyModal.member.requestedPackage || 'Package not specified'"></div>
                            <div class="text-xs text-zinc-400" x-text="'Submitted ' + (verifyModal.member.paymentSubmittedDate || '')"></div>
                        </div>
                        <a :href="verifyModal.member.paymentProofUrl" x-show="verifyModal.member.paymentProofUrl" target="_blank" rel="noopener" class="text-red-600 text-sm underline shrink-0">View proof</a>
                    </div>
                </div>

                <!-- Validation errors -->
                <div x-show="verifyModal.errors.length" x-cloak class="mb-5 bg-red-50 border border-red-100 text-red-700 rounded-2xl px-5 py-4 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        <template x-for="(msg, i) in verifyModal.errors" :key="i">
                            <li x-text="msg"></li>
                        </template>
                    </ul>
                </div>

                <label class="block text-sm font-medium text-zinc-600 mb-2">Membership Package (optional)</label>
                <select x-model="verifyModal.package" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                    <option value="">— Assign later —</option>
                    <template x-for="p in membershipPackages" :key="p">
                        <option x-text="p"></option>
                    </template>
                </select>

                <div class="mt-8 flex gap-4">
                    <button @click="verifyModal.open = false" :disabled="verifyModal.saving" class="flex-1 py-4 border rounded-3xl hover:bg-zinc-50 flex items-center justify-center gap-2 disabled:opacity-50">
                        <i class="fa-solid fa-xmark"></i> Cancel
                    </button>
                    <button @click="verifyMember()" :disabled="verifyModal.saving" class="flex-1 py-4 bg-emerald-600 text-white rounded-3xl hover:bg-emerald-700 flex items-center justify-center gap-2 disabled:opacity-50">
                        <i class="fa-solid" :class="verifyModal.saving ? 'fa-circle-notch fa-spin' : 'fa-user-check'"></i>
                        <span x-text="verifyModal.saving ? 'Verifying…' : 'Verify Member'"></span>
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>

<!-- Record Payment (staff: attach a bank-transfer proof / set package for a member) -->
@php $bank = config('contact.bank'); @endphp
<div x-show="paymentModal.open" x-cloak x-transition.opacity
     @click.self="paymentModal.open = false" @keydown.escape.window="paymentModal.open = false"
     class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 p-4">
    <div x-show="paymentModal.open" x-transition class="bg-white rounded-3xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
        <template x-if="paymentModal.member">
            <div class="p-6 sm:p-8">
                <h3 class="text-xl font-semibold mb-1">Record Payment</h3>
                <p class="text-sm text-zinc-400 mb-6">
                    Attach a bank-transfer proof for
                    <span class="font-medium text-zinc-600" x-text="paymentModal.member.name"></span>
                    (<span x-text="paymentModal.member.id"></span>).
                </p>

                <div x-show="paymentModal.errors.length" x-cloak class="mb-5 bg-red-50 border border-red-100 text-red-700 rounded-2xl px-5 py-4 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        <template x-for="(msg, i) in paymentModal.errors" :key="i"><li x-text="msg"></li></template>
                    </ul>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-zinc-600 mb-2">Membership Package</label>
                        <select x-model="paymentModal.package" class="w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                            <option value="">— Not specified —</option>
                            <template x-for="p in membershipPackages" :key="p"><option x-text="p"></option></template>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-600 mb-2">Proof of transfer</label>
                        <input type="file" accept="image/*,application/pdf"
                               @change="paymentModal.proof = $event.target.files[0]; paymentModal.proofName = ($event.target.files[0] && $event.target.files[0].name) || ''"
                               class="w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-2xl file:border-0 file:bg-red-50 file:text-red-600 hover:file:bg-red-100">
                        <p x-show="paymentModal.proofName" x-cloak class="text-xs text-zinc-500 mt-2" x-text="paymentModal.proofName"></p>
                        <p x-show="paymentModal.member.paymentProofUrl && !paymentModal.proofName" x-cloak class="text-xs text-zinc-500 mt-2">
                            Current proof: <a :href="paymentModal.member.paymentProofUrl" target="_blank" rel="noopener" class="text-red-600 underline">view</a>
                        </p>
                    </div>

                    <!-- Bank Mandiri details (simulated) -->
                    <div class="bg-zinc-50 rounded-3xl p-5 text-sm">
                        <div class="text-xs uppercase tracking-widest text-zinc-400 mb-3">Bank Transfer (simulated)</div>
                        <div class="grid grid-cols-2 gap-y-2">
                            <span class="text-zinc-500">Bank</span><span class="font-medium text-right">{{ $bank['name'] }}</span>
                            <span class="text-zinc-500">Account No.</span><span class="font-medium text-right">{{ $bank['account_number'] }}</span>
                            <span class="text-zinc-500">Account Name</span><span class="font-medium text-right">{{ $bank['account_holder'] }}</span>
                            <span class="text-zinc-500">Branch</span><span class="font-medium text-right">{{ $bank['branch'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex gap-4">
                    <button @click="paymentModal.open = false" :disabled="paymentModal.saving" class="flex-1 py-5 border rounded-3xl hover:bg-zinc-50 flex items-center justify-center gap-2 disabled:opacity-50">
                        <i class="fa-solid fa-xmark"></i> Cancel
                    </button>
                    <button @click="savePayment()" :disabled="paymentModal.saving" class="flex-1 py-5 bg-red-600 text-white rounded-3xl hover:bg-red-700 flex items-center justify-center gap-2 disabled:opacity-50">
                        <i class="fa-solid" :class="paymentModal.saving ? 'fa-circle-notch fa-spin' : 'fa-floppy-disk'"></i>
                        <span x-text="paymentModal.saving ? 'Saving…' : 'Save Payment'"></span>
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
                <div class="grid grid-cols-2 gap-4">
                    <select x-model="itemModal.discountType" class="block w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300">
                        <option value="">No discount</option>
                        <option value="percent">Discount (%)</option>
                        <option value="amount">Discount (Rp)</option>
                    </select>
                    <input x-model.number="itemModal.discountValue" type="number" min="0" :disabled="!itemModal.discountType"
                           class="block w-full border rounded-3xl px-6 py-4 outline-none focus:border-red-300 disabled:bg-zinc-100 disabled:text-zinc-400"
                           :placeholder="itemModal.discountType === 'percent' ? 'e.g. 20' : 'e.g. 50000'">
                </div>
                <div x-show="itemModal.discountType" x-cloak class="text-sm text-zinc-500 px-2">
                    Final price:
                    <span class="font-semibold text-red-600" x-text="formatRp(itemModalFinalPrice)"></span>
                    <span x-show="itemModalFinalPrice !== (Number(itemModal.price) || 0)" class="text-xs text-zinc-400 line-through ml-1" x-text="formatRp(Number(itemModal.price) || 0)"></span>
                </div>
            </div>
            <div class="mt-8 flex gap-4">
                <button @click="itemModal.open = false" :disabled="itemModal.saving" class="flex-1 py-5 border rounded-3xl hover:bg-zinc-50 flex items-center justify-center gap-2 disabled:opacity-50">
                    <i class="fa-solid fa-xmark"></i> Cancel
                </button>
                <button @click="saveItem()" :disabled="itemModal.saving" class="flex-1 py-5 bg-red-600 text-white rounded-3xl hover:bg-red-700 flex items-center justify-center gap-2 disabled:opacity-50">
                    <i class="fa-solid" :class="itemModal.saving ? 'fa-circle-notch fa-spin' : 'fa-floppy-disk'"></i> <span x-text="itemModal.editingId ? 'Save Changes' : 'Add to Catalog'"></span>
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

            <!-- Item count + delete (edit mode only). Delete is enabled only when the category is empty. -->
            <template x-if="categoryModal.editingName">
                <div class="mt-6 rounded-3xl border border-zinc-200 bg-zinc-50 px-6 py-4">
                    <div class="flex items-center justify-between gap-4">
                        <div class="text-sm">
                            <div class="text-zinc-400">Items in this category</div>
                            <div class="font-semibold text-zinc-800">
                                <span x-text="editingCategoryItemCount"></span>
                                <span x-text="editingCategoryItemCount === 1 ? 'item' : 'items'"></span>
                            </div>
                        </div>
                        <button type="button" @click="deleteCategory()" :disabled="editingCategoryItemCount > 0"
                                :title="editingCategoryItemCount > 0 ? 'Move or delete its items before deleting this category' : 'Delete this category'"
                                class="px-5 py-3 rounded-3xl border border-red-200 text-red-600 hover:bg-red-50 flex items-center justify-center gap-2 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-transparent">
                            <i class="fa-solid fa-trash-can"></i> Delete
                        </button>
                    </div>
                    <p x-show="editingCategoryItemCount > 0" class="text-xs text-zinc-400 mt-2">
                        Remove or reassign its <span x-text="editingCategoryItemCount"></span> item(s) before this category can be deleted.
                    </p>
                </div>
            </template>

            <div class="mt-8 flex gap-4">
                <button @click="categoryModal.open = false" :disabled="categoryModal.saving" class="flex-1 py-5 border rounded-3xl hover:bg-zinc-50 flex items-center justify-center gap-2 disabled:opacity-50">
                    <i class="fa-solid fa-xmark"></i> Cancel
                </button>
                <button @click="saveCategory()" :disabled="categoryModal.saving" class="flex-1 py-5 bg-red-600 text-white rounded-3xl hover:bg-red-700 flex items-center justify-center gap-2 disabled:opacity-50">
                    <i class="fa-solid" :class="categoryModal.saving ? 'fa-circle-notch fa-spin' : 'fa-floppy-disk'"></i> <span x-text="categoryModal.editingName ? 'Save Changes' : 'Add Category'"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation / alert modal (move to trash, permanent delete, empty trash) -->
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
                    <i class="fa-solid" :class="confirmModal.confirmIcon"></i> <span x-text="confirmModal.confirmLabel"></span>
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
