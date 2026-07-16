<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        $catalog = $this->gymCatalog();

        $member = $request->user()->member;

        return view('member.dashboard', [
            'member' => $member,
            'packages' => $catalog->where('cat', 'Membership')->values()->all(),
            'classes' => $catalog->whereIn('cat', ['Class Pass', 'Personal Training'])->values()->all(),
            'whatsapp' => config('contact.whatsapp'),
            'bank' => config('contact.bank'),
        ]);
    }

    /**
     * Member submits a bank-transfer proof for a chosen package from the
     * member portal. Stays "pending" until staff verify it.
     */
    public function submitPayment(Request $request): RedirectResponse
    {
        $member = $request->user()->member;

        abort_unless($member !== null, 404);

        $packages = $this->gymCatalog()
            ->where('cat', 'Membership')
            ->pluck('name')
            ->all();

        $validated = $request->validate([
            'requested_package' => ['required', 'string', $packages ? Rule::in($packages) : 'string'],
            'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);

        $member->update([
            'requested_package' => $validated['requested_package'],
            'payment_proof_path' => $request->file('payment_proof')->store('payment-proofs', 'public'),
            'payment_submitted_at' => now(),
        ]);

        return back()->with('status', 'payment-submitted');
    }

    /**
     * Staff (manager/cashier) record a bank-transfer proof and/or intended
     * package for a member from the POS. Returns the refreshed POS record.
     */
    public function uploadPayment(Request $request, Member $member): JsonResponse
    {
        $packages = $this->gymCatalog()
            ->where('cat', 'Membership')
            ->pluck('name')
            ->all();

        $validated = $request->validate([
            'requested_package' => ['nullable', 'string', $packages ? Rule::in($packages) : 'string'],
            'payment_proof' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);

        if (! empty($validated['requested_package'])) {
            $member->requested_package = $validated['requested_package'];
        }

        if ($request->hasFile('payment_proof')) {
            $member->payment_proof_path = $request->file('payment_proof')->store('payment-proofs', 'public');
            $member->payment_submitted_at = now();
        }

        $member->save();

        return response()->json([
            'member' => $member->load('user')->toPosArray(),
        ]);
    }

    /**
     * Staff (manager) creates a new member complete with login credentials and
     * gym profile. Returns the saved member in the POS table shape so the
     * Alpine app can insert it without a full reload.
     */
    public function store(Request $request): JsonResponse
    {
        $packages = $this->gymCatalog()
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
                // Staff-created members are trusted, so they are verified on creation.
                'verified_at' => now(),
            ]);
        });

        return response()->json([
            'member' => $member->load('user')->toPosArray(),
        ], 201);
    }

    /**
     * Staff (manager or cashier) verify a pending registrant. Optionally assign
     * a membership package at the same time; when a package is given and the
     * member has no expiry yet, default it to one month out (mirrors store()).
     */
    public function verify(Request $request, Member $member): JsonResponse
    {
        $packages = $this->gymCatalog()
            ->where('cat', 'Membership')
            ->pluck('name')
            ->all();

        $validated = $request->validate([
            'membership_package' => ['nullable', 'string', $packages ? Rule::in($packages) : 'string'],
        ]);

        // Default to the package the member already requested when paying.
        $package = $validated['membership_package'] ?? null;
        if (! $package) {
            $package = $member->requested_package ?: null;
        }

        if ($package) {
            $member->membership_package = $package;

            if ($member->expiry_date === null) {
                $member->expiry_date = Carbon::today()->addMonth();
            }
        }

        if ($member->verified_at === null) {
            $member->verified_at = now();
        }

        $member->save();

        return response()->json([
            'member' => $member->load('user')->toPosArray(),
        ]);
    }

    /**
     * Staff (manager/cashier) soft-delete a member (moves them to the Trash).
     */
    public function destroy(Member $member): JsonResponse
    {
        $member->delete();

        return response()->json(['ok' => true]);
    }

    /**
     * Restore a soft-deleted member from the Trash (resolved incl. trashed).
     */
    public function restore(string $member): JsonResponse
    {
        $record = Member::withTrashed()->where('member_code', $member)->firstOrFail();
        $record->restore();

        return response()->json([
            'member' => $record->load('user')->toPosArray(),
        ]);
    }

    /**
     * The gym catalog (packages, classes, PT) sourced from the database and
     * mapped to the POS array shape used by the member portal.
     *
     * @return Collection<int, array<string, mixed>>
     */
    private function gymCatalog(): Collection
    {
        return Product::forUnit('gym')
            ->with('category')
            ->orderBy('id')
            ->get()
            ->map(fn (Product $p) => $p->toPosArray());
    }
}
