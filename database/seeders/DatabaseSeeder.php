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
        ]);
    }
}
