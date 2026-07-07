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
                    @php $active = $member->isActive() && $member->membership_package; @endphp
                    <span class="px-4 py-1.5 text-xs font-medium rounded-3xl
                        {{ $active ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ $active ? 'Active' : ($member->membership_package ? 'Expired' : 'Pending') }}
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

    <!-- Profile summary -->
    @if ($member)
        <div class="bg-white rounded-3xl p-7 shadow-sm mt-6">
            <h3 class="font-semibold mb-5">My Details</h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-5 text-sm">
                <div><dt class="text-zinc-400 text-xs">Email</dt><dd class="font-medium mt-1 break-all">{{ auth()->user()->email }}</dd></div>
                <div><dt class="text-zinc-400 text-xs">Phone / WhatsApp</dt><dd class="font-medium mt-1">{{ $member->phone ?: '—' }}</dd></div>
                <div><dt class="text-zinc-400 text-xs">Gender</dt><dd class="font-medium mt-1">{{ $member->gender ?: '—' }}</dd></div>
                <div><dt class="text-zinc-400 text-xs">Date of Birth</dt><dd class="font-medium mt-1">{{ optional($member->date_of_birth)->format('d M Y') ?: '—' }}</dd></div>
                <div><dt class="text-zinc-400 text-xs">{{ $member->id_type ?: 'ID' }} Number</dt><dd class="font-medium mt-1">{{ $member->id_number ?: '—' }}</dd></div>
                <div><dt class="text-zinc-400 text-xs">Emergency Contact</dt><dd class="font-medium mt-1">{{ $member->emergency_contact_name ? $member->emergency_contact_name.' ('.$member->emergency_contact_phone.')' : '—' }}</dd></div>
                <div class="sm:col-span-2 lg:col-span-3"><dt class="text-zinc-400 text-xs">Address</dt><dd class="font-medium mt-1">{{ $member->address ?: '—' }}</dd></div>
            </dl>
        </div>
    @endif

    <!-- Gym packages (from POS catalog) -->
    <div class="mt-10">
        <div class="uppercase text-xs tracking-widest text-zinc-400 font-medium mb-3 px-1">Membership Packages</div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @forelse ($packages as $p)
                <div class="bg-white rounded-3xl p-6 shadow-sm">
                    <div class="text-3xl">{{ $p['emoji'] ?? '🏋️' }}</div>
                    <div class="font-semibold mt-3">{{ $p['name'] }}</div>
                    <div class="text-red-600 font-semibold mt-1">Rp {{ number_format($p['price'] ?? 0, 0, ',', '.') }}</div>
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
                    <div class="text-3xl">{{ $c['emoji'] ?? '🥊' }}</div>
                    <div class="font-semibold mt-3">{{ $c['name'] }}</div>
                    <div class="text-xs text-zinc-400 mt-0.5">{{ $c['cat'] ?? '' }}</div>
                    <div class="text-red-600 font-semibold mt-1">Rp {{ number_format($c['price'] ?? 0, 0, ',', '.') }}</div>
                </div>
            @empty
                <p class="text-sm text-zinc-400">No classes available.</p>
            @endforelse
        </div>
    </div>
</x-member-layout>
