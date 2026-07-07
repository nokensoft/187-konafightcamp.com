<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A valid public member registration payload.
     *
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'phone' => '628123456789',
            'gender' => 'Male',
            'date_of_birth' => '1995-05-20',
            'id_type' => 'KTP',
            'id_number' => '3204150595010101',
            'address' => 'Jl. Sunset Road No. 1, Bali',
            'emergency_contact_name' => 'Siti',
            'emergency_contact_phone' => '628120000999',
            'terms' => '1',
        ], $overrides);
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', $this->validPayload());

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        $user = User::where('email', 'test@example.com')->first();
        $this->assertNotNull($user);
        $this->assertSame('member', $user->role);
        $this->assertNotNull($user->member);
        $this->assertSame('628123456789', $user->member->phone);
        $this->assertNotNull($user->member->terms_accepted_at);
    }

    public function test_registration_requires_accepting_terms(): void
    {
        $response = $this->post('/register', $this->validPayload(['terms' => null]));

        $response->assertSessionHasErrors('terms');
        $this->assertGuest();
    }
}
