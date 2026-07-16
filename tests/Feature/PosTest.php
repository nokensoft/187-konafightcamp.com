<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PosTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/pos')->assertRedirect('/login');
    }

    public function test_root_redirects_authenticated_user_to_pos(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/')->assertRedirect(route('pos'));
    }

    public function test_manager_can_view_pos_with_seeded_catalog(): void
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

        $response = $this->actingAs($manager)->get('/pos');

        $response->assertOk();
        $response->assertSee('Kona Fight Camp');
        $response->assertSee('Recent Activity');
        $response->assertSee('Monthly Premium'); // catalog data injected from the DB
        $response->assertSee('Trash');            // manager recycle-bin partial present
    }

    public function test_cashier_can_view_pos(): void
    {
        $cashier = User::factory()->create(); // default role = cashier

        $this->assertSame('cashier', $cashier->role);
        $this->actingAs($cashier)->get('/pos')->assertOk();
    }
}
