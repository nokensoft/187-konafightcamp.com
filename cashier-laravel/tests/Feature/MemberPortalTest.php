<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    }

    public function test_cashier_cannot_create_members(): void
    {
        $cashier = User::factory()->create(); // default role = cashier

        $this->actingAs($cashier)->postJson('/members', [
            'name' => 'Nope',
            'email' => 'nope@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '628000',
            'gender' => 'Male',
            'membership_type' => 'Local',
            'id_number' => '123',
        ])->assertForbidden();

        $this->assertDatabaseMissing('users', ['email' => 'nope@example.com']);
    }
}
