<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class MemberController extends Controller
{
    /**
     * Member portal dashboard. Separate from the manager/cashier POS: it shows
     * the signed-in member's membership status alongside the live gym catalog
     * (packages & classes) sourced from the same POS data.
     */
    public function dashboard(Request $request): View
    {
        $gym = $this->gymData();
        $catalog = collect($gym['catalog'] ?? []);

        $member = $request->user()->member;

        return view('member.dashboard', [
            'member' => $member,
            'packages' => $catalog->where('cat', 'Membership')->values()->all(),
            'classes' => $catalog->whereIn('cat', ['Class Pass', 'Personal Training'])->values()->all(),
            'whatsapp' => config('contact.whatsapp'),
        ]);
    }

    /**
     * Staff (manager) creates a new member complete with login credentials and
     * gym profile. Returns the saved member in the POS table shape so the
     * Alpine app can insert it without a full reload.
     */
    public function store(Request $request): JsonResponse
    {
        $gym = $this->gymData();
        $packages = collect($gym['catalog'] ?? [])
            ->where('cat', 'Membership')
            ->pluck('name')
            ->all();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:30'],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'membership_type' => ['required', Rule::in(['Local', 'Tourist'])],
            'id_number' => ['required', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:1000'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:30'],
            'membership_package' => ['nullable', 'string', $packages ? Rule::in($packages) : 'string'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'id_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $photoPath = null;
        if ($request->hasFile('id_photo')) {
            $photoPath = $request->file('id_photo')->store('id-photos', 'public');
        }

        $member = DB::transaction(function () use ($validated, $photoPath) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'member',
            ]);

            return Member::create([
                'user_id' => $user->id,
                'member_code' => Member::codeForUser($user->id),
                'phone' => $validated['phone'],
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'id_type' => ($validated['membership_type'] === 'Tourist') ? 'Passport' : 'KTP',
                'id_number' => $validated['id_number'],
                'id_photo_path' => $photoPath,
                'address' => $validated['address'] ?? null,
                'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
                'emergency_contact_phone' => $validated['emergency_contact_phone'] ?? null,
                'membership_package' => $validated['membership_package'] ?? null,
                'membership_type' => $validated['membership_type'],
                'registration_date' => Carbon::today(),
                'expiry_date' => ($validated['membership_package'] ?? null) ? Carbon::today()->addMonth() : null,
                'notes' => $validated['notes'] ?? null,
                'terms_accepted_at' => now(),
            ]);
        });

        return response()->json([
            'member' => $member->load('user')->toPosArray(),
        ], 201);
    }

    /**
     * Read the gym unit's prototype data (catalog/categories) from JSON.
     *
     * @return array<string, mixed>
     */
    private function gymData(): array
    {
        $path = resource_path('data/gym.json');

        return File::exists($path)
            ? (json_decode(File::get($path), true) ?: [])
            : [];
    }
}
