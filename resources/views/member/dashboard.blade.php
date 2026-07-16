@php
    $waHref = 'https://wa.me/'.preg_replace('/\D+/', '', (string) $whatsapp);
@endphp
<x-member-layout>
    <!-- Greeting -->
    <div class="mb-8">
        <h1 class="text-2xl lg:text-3xl font-semibold tracking-tight">
            Welcome, {{ auth()->user()->name }}
        </h1>
        <p class="text-zinc-500 mt-1">Here's your Kona Fight Camp membership.</p>
    </div>

    @if (session('status') === 'payment-submitted')
        <div class="mb-6 rounded-3xl bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 text-sm flex items-center gap-3">
            <i class="fa-solid fa-circle-check"></i>
            <span>Payment proof submitted. Our staff will verify your membership shortly.</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Membership status -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-7 shadow-sm">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-zinc-500 text-sm">Current Membership</p>
                    <p class="text-2xl font-semibold mt-2">
                        {{ optional($member)->membership_package ?: 'No active package' }}
                    </p>
                </div>
                @if ($member)
                    @php
                        $status = $member->paymentStatus();
                        $statusLabel = $status === 'active'
                            ? 'Active'
                            : ($status === 'awaiting'
                                ? 'Awaiting verification'
                                : ($member->membership_package ? 'Expired' : 'Pending'));
                        $statusClass = $status === 'active'
                            ? 'bg-emerald-100 text-emerald-700'
                            : ($status === 'awaiting' ? 'bg-amber-100 text-amber-700' : 'bg-zinc-100 text-zinc-600');
                    @endphp
                    <span class="px-4 py-1.5 text-xs font-medium rounded-3xl {{ $statusClass }}">
                        {{ $statusLabel }}
                    </span>
                @endif
            </div>

            @if ($member)
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-7 text-sm">
                    <div>
                        <div class="text-zinc-400 text-xs">Member ID</div>
                        <div class="font-medium mt-1">{{ $member->member_code }}</div>
                    </div>
                    <div>
                        <div class="text-zinc-400 text-xs">Type</div>
                        <div class="font-medium mt-1">{{ $member->membership_type ?: '—' }}</div>
                    </div>
                    <div>
                        <div class="text-zinc-400 text-xs">Registered</div>
                        <div class="font-medium mt-1">{{ optional($member->registration_date)->format('d M Y') ?: '—' }}</div>
                    </div>
                    <div>
                        <div class="text-zinc-400 text-xs">Expires</div>
                        <div class="font-medium mt-1">{{ optional($member->expiry_date)->format('d M Y') ?: 'Pending' }}</div>
                    </div>
                </div>
            @else
                <p class="text-sm text-zinc-500 mt-6">
                    Your membership profile isn't set up yet. Please contact the front desk to complete your registration.
                </p>
            @endif
        </div>

        <!-- Need help / WhatsApp -->
        <div class="bg-white rounded-3xl p-7 shadow-sm flex flex-col">
            <div class="w-11 h-11 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                <i class="fa-brands fa-whatsapp"></i>
            </div>
            <h3 class="font-semibold mt-4">Need help?</h3>
            <p class="text-sm text-zinc-500 mt-1 flex-1">
                Forgot your password or need to update your membership? Message our admin on WhatsApp.
            </p>
            <a href="{{ $waHref }}" target="_blank" rel="noopener"
               class="mt-5 inline-flex items-center justify-center gap-2 bg-emerald-600 text-white px-5 py-3 rounded-3xl hover:bg-emerald-700 text-sm font-medium">
                <i class="fa-brands fa-whatsapp"></i> Contact Admin
            </a>
        </div>
    </div>

    <!-- Buy / Renew membership: bank transfer + proof upload -->
    @if ($member)
        <div class="bg-white rounded-3xl p-7 shadow-sm mt-6"
             x-data="{
                packages: @js($packages),
                pkg: @js($member->requested_package ?? ''),
                fileName: '',
                previewUrl: '',
                dragging: false,
                get selected() { return this.packages.find(p => p.name === this.pkg) || null; },
                formatRp(n) { return 'Rp ' + (Number(n) || 0).toLocaleString('id-ID'); },
                pickFile(file) {
                    if (! file) return;
                    this.fileName = file.name;
                    this.previewUrl = (file.type || '').startsWith('image/') ? URL.createObjectURL(file) : '';
                },
             }">
            <h3 class="font-semibold">Buy / Renew Membership</h3>
            <p class="text-sm text-zinc-500 mt-1">Transfer to the account below, then upload your proof of payment. Our staff will verify your membership.</p>

            <form method="POST" action="{{ route('member.payment') }}" enctype="multipart/form-data" class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                @csrf
                <!-- Package + proof upload -->
                <div class="space-y-5">
                    <div>
                        <label for="requested_package" class="block text-sm font-medium text-zinc-600 mb-2">Choose a package *</label>
                        <select id="requested_package" name="requested_package" x-model="pkg" required
                                class="block w-full border-zinc-300 focus:border-red-500 focus:ring-red-500 rounded-3xl shadow-sm">
                            <option value="">— Select a package —</option>
                            <template x-for="p in packages" :key="p.name">
                                <option :value="p.name" x-text="p.name + ' — ' + formatRp(p.finalPrice ?? p.price)"></option>
                            </template>
                        </select>
                        <x-input-error :messages="$errors->get('requested_package')" class="mt-2" />
                    </div>

                    <div x-on:dragover.prevent="dragging = true"
                         x-on:dragleave.prevent="dragging = false"
                         x-on:drop.prevent="dragging = false; $refs.proof.files = $event.dataTransfer.files; pickFile($event.dataTransfer.files[0])">
                        <label class="block text-sm font-medium text-zinc-600 mb-2">Proof of transfer *</label>
                        <label for="payment_proof"
                               class="flex flex-col items-center justify-center gap-2 px-6 py-7 border-2 border-dashed rounded-3xl cursor-pointer transition"
                               :class="dragging ? 'border-red-500 bg-red-50' : 'border-zinc-300 hover:border-red-400'">
                            <template x-if="! fileName">
                                <div class="text-center">
                                    <i class="fa-solid fa-cloud-arrow-up text-2xl text-zinc-400"></i>
                                    <p class="text-sm text-zinc-600 mt-2">Drag &amp; drop your receipt, or <span class="text-red-600 font-medium">browse</span></p>
                                    <p class="text-xs text-zinc-400 mt-1">JPG, PNG or PDF up to 4MB</p>
                                </div>
                            </template>
                            <template x-if="fileName">
                                <div class="text-center w-full">
                                    <template x-if="previewUrl">
                                        <img :src="previewUrl" alt="Proof preview" class="mx-auto max-h-36 rounded-xl object-contain">
                                    </template>
                                    <template x-if="! previewUrl">
                                        <i class="fa-solid fa-file-lines text-3xl text-zinc-400"></i>
                                    </template>
                                    <p class="text-sm text-zinc-700 mt-2 truncate" x-text="fileName"></p>
                                </div>
                            </template>
                            <input id="payment_proof" name="payment_proof" type="file" accept="image/jpeg,image/png,application/pdf"
                                   class="hidden" x-ref="proof" @change="pickFile($event.target.files[0])" required>
                        </label>
                        <x-input-error :messages="$errors->get('payment_proof')" class="mt-2" />
                    </div>

                    <button type="submit" class="inline-flex items-center justify-center gap-2 bg-red-600 text-white px-6 py-3.5 rounded-3xl hover:bg-red-700 text-sm font-medium">
                        <i class="fa-solid fa-paper-plane"></i> Submit Payment Proof
                    </button>
                </div>

                <!-- Bank details (simulated) -->
                <div class="bg-zinc-50 rounded-3xl p-6"
                     x-data="{ copied: false, copy(v) { if (navigator.clipboard) navigator.clipboard.writeText(v); this.copied = true; setTimeout(() => this.copied = false, 1500); } }">
                    <div class="text-xs uppercase tracking-widest text-zinc-400 mb-4">Bank Transfer</div>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between gap-4"><dt class="text-zinc-500">Bank</dt><dd class="font-medium">{{ $bank['name'] }}</dd></div>
                        <div class="flex justify-between items-center gap-4">
                            <dt class="text-zinc-500">Account No.</dt>
                            <dd class="font-medium flex items-center gap-2">
                                <span>{{ $bank['account_number'] }}</span>
                                <button type="button" @click="copy('{{ $bank['account_number'] }}')" class="text-red-600 hover:text-red-700" title="Copy">
                                    <i class="fa-regular fa-copy text-xs"></i>
                                </button>
                                <span x-show="copied" x-cloak class="text-xs text-emerald-600">Copied</span>
                            </dd>
                        </div>
                        <div class="flex justify-between gap-4"><dt class="text-zinc-500">Account Name</dt><dd class="font-medium text-right">{{ $bank['account_holder'] }}</dd></div>
                        <div class="flex justify-between gap-4"><dt class="text-zinc-500">Branch</dt><dd class="font-medium text-right">{{ $bank['branch'] }}</dd></div>
                        <div class="flex justify-between gap-4 border-t border-zinc-200 pt-3 mt-3" x-show="selected" x-cloak>
                            <dt class="text-zinc-500">Amount to transfer</dt>
                            <dd class="font-semibold text-red-600" x-text="selected ? formatRp(selected.finalPrice ?? selected.price) : ''"></dd>
                        </div>
                    </dl>
                    <p class="text-xs text-zinc-400 mt-4">Simulated bank details for this prototype.</p>
                </div>
            </form>

            @if ($member->hasSubmittedPayment())
                <div class="mt-6 rounded-2xl border border-amber-100 bg-amber-50 px-5 py-4 text-sm text-amber-700 flex flex-wrap items-center gap-3">
                    <i class="fa-solid fa-clock"></i>
                    <span>Proof submitted on {{ optional($member->payment_submitted_at)->format('d M Y') }}@if ($member->requested_package) for “{{ $member->requested_package }}”@endif. Awaiting staff verification.</span>
                    @if ($member->payment_proof_path)
                        <a href="{{ asset('storage/'.$member->payment_proof_path) }}" target="_blank" rel="noopener" class="ml-auto underline hover:no-underline">View proof</a>
                    @endif
                </div>
            @endif
        </div>
    @endif

    <!-- Gym packages (from POS catalog) -->
    <div class="mt-10">
        <div class="uppercase text-xs tracking-widest text-zinc-400 font-medium mb-3 px-1">Membership Packages</div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @forelse ($packages as $p)
                <div class="bg-white rounded-3xl p-6 shadow-sm">
                    <div class="font-semibold">{{ $p['name'] }}</div>
                    <div class="text-red-600 font-semibold mt-1">Rp {{ number_format($p['finalPrice'] ?? $p['price'] ?? 0, 0, ',', '.') }}</div>
                    @if (!empty($p['hasDiscount']))
                        <div class="text-xs text-zinc-400 line-through">Rp {{ number_format($p['price'], 0, ',', '.') }}</div>
                    @endif
                </div>
            @empty
                <p class="text-sm text-zinc-400">No packages available.</p>
            @endforelse
        </div>
    </div>

    <!-- Classes & training (from POS catalog) -->
    <div class="mt-8">
        <div class="uppercase text-xs tracking-widest text-zinc-400 font-medium mb-3 px-1">Classes &amp; Training</div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @forelse ($classes as $c)
                <div class="bg-white rounded-3xl p-6 shadow-sm">
                    <div class="font-semibold">{{ $c['name'] }}</div>
                    <div class="text-xs text-zinc-400 mt-0.5">{{ $c['cat'] ?? '' }}</div>
                    <div class="text-red-600 font-semibold mt-1">Rp {{ number_format($c['finalPrice'] ?? $c['price'] ?? 0, 0, ',', '.') }}</div>
                    @if (!empty($c['hasDiscount']))
                        <div class="text-xs text-zinc-400 line-through">Rp {{ number_format($c['price'], 0, ',', '.') }}</div>
                    @endif
                </div>
            @empty
                <p class="text-sm text-zinc-400">No classes available.</p>
            @endforelse
        </div>
    </div>
</x-member-layout>
