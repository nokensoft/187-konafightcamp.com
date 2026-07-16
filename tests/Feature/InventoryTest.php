<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    private function gymCategory(string $name = 'Membership'): Category
    {
        return Category::create(['unit' => 'gym', 'name' => $name]);
    }

    public function test_manager_can_create_a_product(): void
    {
        $manager = User::factory()->manager()->create();
        $this->gymCategory();

        $response = $this->actingAs($manager)->postJson('/units/gym/products', [
            'name' => 'Monthly Premium',
            'cat' => 'Membership',
            'price' => 450000,
            'stock' => 999,
        ]);

        $response->assertCreated()
            ->assertJsonPath('item.name', 'Monthly Premium')
            ->assertJsonPath('item.cat', 'Membership');

        $this->assertDatabaseHas('products', [
            'unit' => 'gym',
            'name' => 'Monthly Premium',
            'price' => 450000,
        ]);
    }

    public function test_manager_can_update_a_product(): void
    {
        $manager = User::factory()->manager()->create();
        $category = $this->gymCategory();
        $product = Product::create([
            'unit' => 'gym',
            'category_id' => $category->id,
            'name' => 'Old Name',
            'price' => 1,
            'stock' => 1,
        ]);

        $this->actingAs($manager)->patchJson("/products/{$product->id}", [
            'name' => 'New Name',
            'cat' => 'Membership',
            'price' => 500,
            'stock' => 5,
        ])->assertOk()->assertJsonPath('item.name', 'New Name');

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'New Name',
            'price' => 500,
            'stock' => 5,
        ]);
    }

    public function test_manager_can_soft_delete_restore_and_force_delete_a_product(): void
    {
        $manager = User::factory()->manager()->create();
        $product = Product::create(['unit' => 'store', 'name' => 'Towel', 'price' => 100, 'stock' => 10]);

        $this->actingAs($manager)->deleteJson("/products/{$product->id}")->assertOk();
        $this->assertSoftDeleted('products', ['id' => $product->id]);

        $this->actingAs($manager)->postJson("/products/{$product->id}/restore")->assertOk();
        $this->assertDatabaseHas('products', ['id' => $product->id, 'deleted_at' => null]);

        $this->actingAs($manager)->deleteJson("/products/{$product->id}/force")->assertOk();
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_product_requires_a_name(): void
    {
        $manager = User::factory()->manager()->create();

        $this->actingAs($manager)->postJson('/units/gym/products', [
            'name' => '',
            'price' => 1,
        ])->assertStatus(422)->assertJsonValidationErrorFor('name');
    }

    public function test_unknown_unit_is_rejected(): void
    {
        $manager = User::factory()->manager()->create();

        $this->actingAs($manager)->postJson('/units/spa/products', [
            'name' => 'Massage',
        ])->assertNotFound();
    }

    public function test_cashier_can_mutate_products(): void
    {
        $cashier = User::factory()->create(); // default role = cashier
        $this->gymCategory();

        $this->actingAs($cashier)->postJson('/units/gym/products', [
            'name' => 'Cashier Pass',
            'cat' => 'Membership',
            'price' => 1,
            'stock' => 1,
        ])->assertCreated();

        $this->assertDatabaseHas('products', ['name' => 'Cashier Pass']);
    }

    public function test_manager_can_create_update_and_delete_a_category(): void
    {
        $manager = User::factory()->manager()->create();

        $id = $this->actingAs($manager)->postJson('/units/store/categories', [
            'name' => 'Supplement',
            'description' => 'Nutrition',
        ])->assertCreated()->json('category.id');

        $this->assertDatabaseHas('categories', ['id' => $id, 'unit' => 'store', 'name' => 'Supplement']);

        $this->actingAs($manager)->patchJson("/categories/{$id}", [
            'name' => 'Supplements',
        ])->assertOk()->assertJsonPath('category.name', 'Supplements');

        $this->actingAs($manager)->deleteJson("/categories/{$id}")->assertOk();
        $this->assertSoftDeleted('categories', ['id' => $id]);
    }

    public function test_duplicate_category_name_is_rejected(): void
    {
        $manager = User::factory()->manager()->create();
        $this->gymCategory('Membership');

        $this->actingAs($manager)->postJson('/units/gym/categories', [
            'name' => 'Membership',
        ])->assertStatus(422)->assertJsonValidationErrorFor('name');
    }

    public function test_category_with_items_cannot_be_deleted(): void
    {
        $manager = User::factory()->manager()->create();
        $category = $this->gymCategory();
        Product::create([
            'unit' => 'gym',
            'category_id' => $category->id,
            'name' => 'Day Pass',
            'price' => 1,
            'stock' => 1,
        ]);

        $this->actingAs($manager)->deleteJson("/categories/{$category->id}")->assertStatus(422);

        $this->assertDatabaseHas('categories', ['id' => $category->id, 'deleted_at' => null]);
    }

    public function test_cashier_can_mutate_categories(): void
    {
        $cashier = User::factory()->create();

        $this->actingAs($cashier)->postJson('/units/store/categories', [
            'name' => 'Apparel',
        ])->assertCreated();

        $this->assertDatabaseHas('categories', ['name' => 'Apparel']);
    }

    public function test_manager_can_create_a_product_with_a_percentage_discount(): void
    {
        $manager = User::factory()->manager()->create();
        $this->gymCategory();

        $this->actingAs($manager)->postJson('/units/gym/products', [
            'name' => 'Monthly Premium',
            'cat' => 'Membership',
            'price' => 100000,
            'stock' => 10,
            'discount_type' => 'percent',
            'discount_value' => 20,
        ])->assertCreated()
            ->assertJsonPath('item.finalPrice', 80000)
            ->assertJsonPath('item.hasDiscount', true);

        $this->assertDatabaseHas('products', [
            'name' => 'Monthly Premium',
            'discount_type' => 'percent',
            'discount_value' => 20,
        ]);
    }

    public function test_manager_can_create_a_product_with_an_amount_discount(): void
    {
        $manager = User::factory()->manager()->create();

        $this->actingAs($manager)->postJson('/units/store/products', [
            'name' => 'Whey Protein',
            'price' => 100000,
            'stock' => 10,
            'discount_type' => 'amount',
            'discount_value' => 30000,
        ])->assertCreated()
            ->assertJsonPath('item.finalPrice', 70000)
            ->assertJsonPath('item.hasDiscount', true);
    }

    public function test_percentage_discount_cannot_exceed_100(): void
    {
        $manager = User::factory()->manager()->create();

        $this->actingAs($manager)->postJson('/units/store/products', [
            'name' => 'Broken',
            'price' => 100000,
            'discount_type' => 'percent',
            'discount_value' => 150,
        ])->assertStatus(422)->assertJsonValidationErrorFor('discount_value');
    }

    public function test_updating_a_product_can_clear_its_discount(): void
    {
        $manager = User::factory()->manager()->create();
        $product = Product::create([
            'unit' => 'store',
            'name' => 'Gym Towel',
            'price' => 50000,
            'stock' => 5,
            'discount_type' => 'percent',
            'discount_value' => 10,
        ]);

        $this->actingAs($manager)->patchJson("/products/{$product->id}", [
            'name' => 'Gym Towel',
            'price' => 50000,
            'stock' => 5,
        ])->assertOk()
            ->assertJsonPath('item.hasDiscount', false)
            ->assertJsonPath('item.finalPrice', 50000);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'discount_type' => null,
            'discount_value' => 0,
        ]);
    }
}
