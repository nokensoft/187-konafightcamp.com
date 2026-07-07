<x-guest-layout maxWidth="3xl">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold tracking-tight">Create your member account</h1>
        <p class="text-zinc-500 text-sm mt-1">Join Kona Fight Camp. Fields marked * are required.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" x-data="{ idType: '{{ old('id_type', 'KTP') }}' }">
        @csrf

        <!-- Account -->
        <div class="uppercase text-xs tracking-widest text-zinc-400 font-medium mb-3">Account</div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <x-input-label for="name" :value="__('Full Name *')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="e.g. Budi Santoso" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="email" :value="__('Email *')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@example.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
            <div>
                <x-input-label for="password" :value="__('Password *')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password *')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <!-- Personal details -->
        <div class="uppercase text-xs tracking-widest text-zinc-400 font-medium mb-3 mt-8">Personal Details</div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <x-input-label for="phone" :value="__('Phone / WhatsApp *')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required placeholder="e.g. 62812xxxxxxx" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="gender" :value="__('Gender *')" />
                <select id="gender" name="gender" required
                        class="block mt-1 w-full border-zinc-300 focus:border-red-500 focus:ring-red-500 rounded-3xl shadow-sm">
                    <option value="Male" @selected(old('gender') === 'Male')>Male</option>
                    <option value="Female" @selected(old('gender') === 'Female')>Female</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
            <div>
                <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" :value="old('date_of_birth')" />
                <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="id_type" :value="__('ID Type *')" />
                <select id="id_type" name="id_type" x-model="idType" required
                        class="block mt-1 w-full border-zinc-300 focus:border-red-500 focus:ring-red-500 rounded-3xl shadow-sm">
                    <option value="KTP">KTP (Indonesian)</option>
                    <option value="Passport">Passport (Tourist)</option>
                </select>
                <x-input-error :messages="$errors->get('id_type')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4">
            <x-input-label for="id_number">
                <span x-text="idType === 'Passport' ? '{{ __('Passport Number *') }}' : '{{ __('KTP Number *') }}'"></span>
            </x-input-label>
            <x-text-input id="id_number" class="block mt-1 w-full" type="text" name="id_number" :value="old('id_number')" required placeholder="ID / KTP / Passport number" />
            <x-input-error :messages="$errors->get('id_number')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="address" :value="__('Address')" />
            <textarea id="address" name="address" rows="2"
                      class="block mt-1 w-full border-zinc-300 focus:border-red-500 focus:ring-red-500 rounded-3xl shadow-sm resize-none"
                      placeholder="Street, city, country">{{ old('address') }}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Emergency contact -->
        <div class="uppercase text-xs tracking-widest text-zinc-400 font-medium mb-3 mt-8">Emergency Contact</div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <x-input-label for="emergency_contact_name" :value="__('Contact Name')" />
                <x-text-input id="emergency_contact_name" class="block mt-1 w-full" type="text" name="emergency_contact_name" :value="old('emergency_contact_name')" placeholder="e.g. Siti" />
                <x-input-error :messages="$errors->get('emergency_contact_name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="emergency_contact_phone" :value="__('Contact Phone')" />
                <x-text-input id="emergency_contact_phone" class="block mt-1 w-full" type="text" name="emergency_contact_phone" :value="old('emergency_contact_phone')" placeholder="e.g. 62812xxxxxxx" />
                <x-input-error :messages="$errors->get('emergency_contact_phone')" class="mt-2" />
            </div>
        </div>

        <!-- Terms -->
        <div class="mt-8">
            <label for="terms" class="flex items-start gap-3">
                <input id="terms" type="checkbox" name="terms" value="1" required @checked(old('terms'))
                       class="mt-0.5 rounded border-zinc-300 text-red-600 shadow-sm focus:ring-red-500">
                <span class="text-sm text-zinc-600">
                    {{ __('I agree to the Terms & Conditions and the membership rules of Kona Fight Camp. *') }}
                </span>
            </label>
            <x-input-error :messages="$errors->get('terms')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-4 mt-8">
            <a class="underline text-sm text-zinc-600 hover:text-zinc-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button>
                <i class="fa-solid fa-user-plus"></i> {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
