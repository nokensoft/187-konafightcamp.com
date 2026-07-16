@php
    $member = $user->member;
@endphp

@if ($member)
    @php
        $idPhotoUrl = $member->id_photo_path ? asset('storage/'.$member->id_photo_path) : null;
        $idIsPdf = $member->id_photo_path && str_ends_with(strtolower($member->id_photo_path), '.pdf');
    @endphp
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('My Details') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Your membership profile and uploaded ID. Contact the front desk to update these.') }}
            </p>
        </header>

        <dl class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5 text-sm">
            <div><dt class="text-zinc-400 text-xs">Member ID</dt><dd class="font-medium mt-1">{{ $member->member_code }}</dd></div>
            <div><dt class="text-zinc-400 text-xs">Phone / WhatsApp</dt><dd class="font-medium mt-1">{{ $member->phone ?: '—' }}</dd></div>
            <div><dt class="text-zinc-400 text-xs">Gender</dt><dd class="font-medium mt-1">{{ $member->gender ?: '—' }}</dd></div>
            <div><dt class="text-zinc-400 text-xs">Date of Birth</dt><dd class="font-medium mt-1">{{ optional($member->date_of_birth)->format('d M Y') ?: '—' }}</dd></div>
            <div><dt class="text-zinc-400 text-xs">{{ $member->id_type ?: 'ID' }} Number</dt><dd class="font-medium mt-1">{{ $member->id_number ?: '—' }}</dd></div>
            <div><dt class="text-zinc-400 text-xs">Emergency Contact</dt><dd class="font-medium mt-1">{{ $member->emergency_contact_name ? $member->emergency_contact_name.' ('.$member->emergency_contact_phone.')' : '—' }}</dd></div>
            <div class="sm:col-span-2"><dt class="text-zinc-400 text-xs">Address</dt><dd class="font-medium mt-1">{{ $member->address ?: '—' }}</dd></div>
        </dl>

        <!-- Uploaded KTP / ID document (or placeholder) -->
        <div class="mt-6">
            <div class="text-zinc-400 text-xs mb-2">{{ $member->id_type ?: 'ID' }} Document</div>
            @if ($idPhotoUrl)
                <a href="{{ $idPhotoUrl }}" target="_blank" rel="noopener" class="inline-block">
                    @if ($idIsPdf)
                        <div class="flex items-center gap-3 rounded-2xl border border-zinc-200 px-5 py-4 hover:border-red-300 transition">
                            <i class="fa-solid fa-file-pdf text-2xl text-red-500"></i>
                            <span class="text-sm font-medium text-zinc-700">View uploaded document</span>
                        </div>
                    @else
                        <img src="{{ $idPhotoUrl }}" alt="{{ $member->id_type ?: 'ID' }} document" class="max-h-48 rounded-2xl border border-zinc-200 object-contain bg-zinc-50">
                    @endif
                </a>
            @else
                <div class="flex flex-col items-center justify-center gap-2 rounded-2xl border-2 border-dashed border-zinc-200 bg-zinc-50 px-6 py-8 text-center">
                    <i class="fa-solid fa-id-card text-3xl text-zinc-300"></i>
                    <p class="text-sm text-zinc-400">No ID document uploaded</p>
                </div>
            @endif
        </div>
    </section>
@endif
