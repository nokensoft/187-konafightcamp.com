<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CatalogSeeder::class);

        User::factory()->manager()->create([
            'name' => 'Manager',
            'email' => 'manager@kfc.test',
        ]);

        User::factory()->create([
            'name' => 'Cashier',
            'email' => 'cashier@kfc.test',
        ]);

        $member = User::factory()->member()->create([
            'name' => 'Member',
            'email' => 'member@kfc.test',
        ]);

        Member::create([
            'user_id' => $member->id,
            'member_code' => Member::codeForUser($member->id),
            'phone' => '6281200000101',
            'gender' => 'Male',
            'date_of_birth' => '1995-05-20',
            'id_type' => 'KTP',
            'id_number' => '3204150595010101',
            'address' => 'Jl. Sunset Road No. 1, Kuta, Bali',
            'emergency_contact_name' => 'Siti',
            'emergency_contact_phone' => '6281200000999',
            'membership_package' => 'Monthly Premium',
            'membership_type' => 'Local',
            'registration_date' => now()->subMonth()->toDateString(),
            'expiry_date' => now()->addMonth()->toDateString(),
            'terms_accepted_at' => now(),
            'verified_at' => now(),
        ]);

        // A pending self-registered member (no package/expiry, not yet verified)
        // so the manager/cashier "Verify" flow is visible right after seeding.
        $pending = User::factory()->member()->create([
            'name' => 'Pending Member',
            'email' => 'pending@kfc.test',
        ]);

        Member::create([
            'user_id' => $pending->id,
            'member_code' => Member::codeForUser($pending->id),
            'phone' => '6281200000202',
            'gender' => 'Female',
            'date_of_birth' => '1998-09-12',
            'id_type' => 'KTP',
            'id_number' => '3204150998020202',
            'address' => 'Jl. Pantai Berawa No. 5, Canggu, Bali',
            'emergency_contact_name' => 'Dewi',
            'emergency_contact_phone' => '6281200000888',
            'membership_type' => 'Local',
            'registration_date' => now()->toDateString(),
            'terms_accepted_at' => now(),
            // Submitted a transfer proof for a package; awaiting staff verification.
            'requested_package' => 'Monthly Premium',
            'payment_proof_path' => 'payment-proofs/sample-transfer.jpg',
            'payment_submitted_at' => now(),
        ]);
    }
}
