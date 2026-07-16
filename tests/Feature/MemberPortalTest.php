<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Member;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MemberPortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_can_view_their_dashboard(): void
    {
        $user = User::factory()->member()->create();
        Member::create([
            'user_id' => $user->id,
            'member_code' => Member::codeForUser($user->id),
            'phone' => '628123456789',
            'gender' => 'Male',
            'membership_type' => 'Local',
        ]);

        $this->actingAs($user)->get('/member')->assertOk()->assertSee('Member Portal');
    }

    public function test_member_is_blocked_from_pos(): void
    {
        $user = User::factory()->member()->create();

        $this->actingAs($user)->get('/pos')->assertForbidden();
    }

    public function test_member_root_redirects_to_member_dashboard(): void
    {
        $user = User::factory()->member()->create();

        $this->actingAs($user)->get('/')->assertRedirect(route('member.dashboard'));
    }

    public function test_manager_can_create_a_member_with_auth_and_profile(): void
    {
        $manager = User::factory()->manager()->create();

        $response = $this->actingAs($manager)->postJson('/members', [
            'name' => 'New Member',
            'email' => 'newmember@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '628111222333',
            'gender' => 'Female',
            'membership_type' => 'Local',
            'id_number' => '3204150595010199',
        ]);

        $response->assertCreated();

        $user = User::where('email', 'newmember@example.com')->first();
        $this->assertNotNull($user);
        $this->assertSame('member', $user->role);
        $this->assertNotNull($user->member);
        $this->assertSame('628111222333', $user->member->phone);
        // Staff-created members are verified on creation.
        $this->assertNotNull($user->member->verified_at);
    }

    public function test_cashier_can_create_members(): void
    {
        $cashier = User::factory()->create(); // default role = cashier

        $response = $this->actingAs($cashier)->postJson('/members', [
            'name' => 'Cashier Member',
            'email' => 'cashiermember@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '628000111222',
            'gender' => 'Male',
            'membership_type' => 'Local',
            'id_number' => '3204150595019999',
        ]);

        $response->assertCreated();

        $user = User::where('email', 'cashiermember@example.com')->first();
        $this->assertNotNull($user);
        $this->assertSame('member', $user->role);
        $this->assertNotNull($user->member->verified_at);
    }

    public function test_manager_can_verify_a_pending_member(): void
    {
        $manager = User::factory()->manager()->create();
        $member = $this->pendingMember();

        $response = $this->actingAs($manager)
            ->patchJson("/members/{$member->member_code}/verify");

        $response->assertOk();
        $this->assertNotNull($member->fresh()->verified_at);
    }

    public function test_cashier_can_verify_a_pending_member(): void
    {
        $cashier = User::factory()->create(); // default role = cashier
        $member = $this->pendingMember();

        $this->actingAs($cashier)
            ->patchJson("/members/{$member->member_code}/verify")
            ->assertOk();

        $this->assertNotNull($member->fresh()->verified_at);
    }

    public function test_verifying_can_assign_a_package_and_expiry(): void
    {
        $manager = User::factory()->manager()->create();

        $category = Category::create(['unit' => 'gym', 'name' => 'Membership']);
        Product::create([
            'unit' => 'gym',
            'category_id' => $category->id,
            'name' => 'Monthly Premium',
            'price' => 450000,
            'stock' => 999,
        ]);

        $member = $this->pendingMember();

        $this->actingAs($manager)
            ->patchJson("/members/{$member->member_code}/verify", [
                'membership_package' => 'Monthly Premium',
            ])
            ->assertOk();

        $member->refresh();
        $this->assertNotNull($member->verified_at);
        $this->assertSame('Monthly Premium', $member->membership_package);
        $this->assertNotNull($member->expiry_date);
    }

    public function test_member_cannot_verify_members(): void
    {
        $member = $this->pendingMember();
        $intruder = User::factory()->member()->create();

        $this->actingAs($intruder)
            ->patchJson("/members/{$member->member_code}/verify")
            ->assertForbidden();

        $this->assertNull($member->fresh()->verified_at);
    }

    public function test_member_can_submit_payment_proof(): void
    {
        Storage::fake('public');
        $this->membershipPackage();
        $member = $this->pendingMember();

        $this->actingAs($member->user)->post('/member/payment', [
            'requested_package' => 'Monthly Premium',
            'payment_proof' => UploadedFile::fake()->image('transfer.jpg'),
        ])->assertRedirect();

        $member->refresh();
        $this->assertSame('Monthly Premium', $member->requested_package);
        $this->assertNotNull($member->payment_submitted_at);
        $this->assertNotNull($member->payment_proof_path);
        Storage::disk('public')->assertExists($member->payment_proof_path);
    }

    public function test_staff_can_record_a_member_payment(): void
    {
        Storage::fake('public');
        $this->membershipPackage();
        $cashier = User::factory()->create(); // default role = cashier
        $member = $this->pendingMember();

        $this->actingAs($cashier)->post("/members/{$member->member_code}/payment", [
            'requested_package' => 'Monthly Premium',
            'payment_proof' => UploadedFile::fake()->image('proof.jpg'),
        ])->assertOk();

        $member->refresh();
        $this->assertSame('Monthly Premium', $member->requested_package);
        $this->assertNotNull($member->payment_proof_path);
        $this->assertNotNull($member->payment_submitted_at);
    }

    public function test_verify_defaults_to_the_requested_package(): void
    {
        $manager = User::factory()->manager()->create();
        $this->membershipPackage();
        $member = $this->pendingMember();
        $member->update(['requested_package' => 'Monthly Premium', 'payment_submitted_at' => now()]);

        $this->actingAs($manager)
            ->patchJson("/members/{$member->member_code}/verify")
            ->assertOk();

        $member->refresh();
        $this->assertNotNull($member->verified_at);
        $this->assertSame('Monthly Premium', $member->membership_package);
        $this->assertNotNull($member->expiry_date);
    }

    public function test_staff_can_soft_delete_and_restore_a_member(): void
    {
        $manager = User::factory()->manager()->create();
        $member = $this->pendingMember();

        $this->actingAs($manager)
            ->deleteJson("/members/{$member->member_code}")
            ->assertOk();
        $this->assertSoftDeleted('members', ['id' => $member->id]);

        $this->actingAs($manager)
            ->postJson("/members/{$member->member_code}/restore")
            ->assertOk();
        $this->assertDatabaseHas('members', ['id' => $member->id, 'deleted_at' => null]);
    }

    public function test_member_cannot_access_staff_member_endpoints(): void
    {
        $member = $this->pendingMember();
        $intruder = User::factory()->member()->create();

        $this->actingAs($intruder)
            ->deleteJson("/members/{$member->member_code}")
            ->assertForbidden();

        $this->assertDatabaseHas('members', ['id' => $member->id, 'deleted_at' => null]);
    }

    public function test_bank_transfer_details_are_configured(): void
    {
        $bank = config('contact.bank');

        $this->assertIsArray($bank);
        $this->assertNotEmpty($bank['name']);
        $this->assertArrayHasKey('account_number', $bank);
        $this->assertArrayHasKey('account_holder', $bank);
    }

    /**
     * Seed a single gym "Monthly Premium" membership package for validation.
     */
    private function membershipPackage(): void
    {
        $category = Category::create(['unit' => 'gym', 'name' => 'Membership']);
        Product::create([
            'unit' => 'gym',
            'category_id' => $category->id,
            'name' => 'Monthly Premium',
            'price' => 450000,
            'stock' => 999,
        ]);
    }

    /**
     * Create a pending (unverified) member, mirroring public self-registration.
     */
    private function pendingMember(): Member
    {
        $user = User::factory()->member()->create();

        return Member::create([
            'user_id' => $user->id,
            'member_code' => Member::codeForUser($user->id),
            'phone' => '628123450000',
            'gender' => 'Female',
            'membership_type' => 'Local',
            'id_number' => '3204150595010202',
            'registration_date' => now()->toDateString(),
            'terms_accepted_at' => now(),
        ]);
    }
}
