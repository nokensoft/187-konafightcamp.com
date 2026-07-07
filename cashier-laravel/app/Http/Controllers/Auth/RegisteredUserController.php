<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:30'],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'id_type' => ['required', Rule::in(['KTP', 'Passport'])],
            'id_number' => ['required', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:1000'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:30'],
            'terms' => ['accepted'],
        ]);

        $user = DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                // Public self-registration creates member accounts; staff roles are assigned separately.
                'role' => 'member',
            ]);

            Member::create([
                'user_id' => $user->id,
                'member_code' => Member::codeForUser($user->id),
                'phone' => $validated['phone'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'id_type' => $validated['id_type'],
                'id_number' => $validated['id_number'],
                'address' => $validated['address'] ?? null,
                'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
                'emergency_contact_phone' => $validated['emergency_contact_phone'] ?? null,
                // Membership type follows the ID type; package/expiry are assigned by staff later.
                'membership_type' => $validated['id_type'] === 'Passport' ? 'Tourist' : 'Local',
                'registration_date' => Carbon::today(),
                'terms_accepted_at' => now(),
            ]);

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
