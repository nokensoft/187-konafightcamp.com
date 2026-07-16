<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * The POS units a catalog item can belong to.
     *
     * @var list<string>
     */
    private const UNITS = ['gym', 'store', 'kitchen'];

    /**
     * Create a catalog item for the given unit and return it in the POS shape.
     */
    public function store(Request $request, string $unit): JsonResponse
    {
        abort_unless(in_array($unit, self::UNITS, true), 404);

        $validated = $this->validateItem($request);

        $product = Product::create(array_merge([
            'unit' => $unit,
            'category_id' => $this->resolveCategoryId($unit, $validated['cat'] ?? null),
            'name' => $validated['name'],
            'price' => $validated['price'] ?? 0,
            'stock' => $validated['stock'] ?? 0,
            'emoji' => $validated['emoji'] ?? null,
        ], $this->discountFrom($validated)));

        return response()->json(['item' => $product->load('category')->toPosArray()], 201);
    }

    /**
     * Update an existing catalog item.
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        $validated = $this->validateItem($request);

        $product->update(array_merge([
            'category_id' => $this->resolveCategoryId($product->unit, $validated['cat'] ?? null),
            'name' => $validated['name'],
            'price' => $validated['price'] ?? 0,
            'stock' => $validated['stock'] ?? 0,
            'emoji' => $validated['emoji'] ?? $product->emoji,
        ], $this->discountFrom($validated)));

        return response()->json(['item' => $product->load('category')->toPosArray()]);
    }

    /**
     * Soft-delete a catalog item (moves it to the Trash).
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(['ok' => true]);
    }

    /**
     * Restore a soft-deleted catalog item from the Trash.
     */
    public function restore(int $id): JsonResponse
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        return response()->json(['item' => $product->load('category')->toPosArray()]);
    }

    /**
     * Permanently delete a catalog item.
     */
    public function forceDelete(int $id): JsonResponse
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->forceDelete();

        return response()->json(['ok' => true]);
    }

    /**
     * Shared validation rules for create/update.
     *
     * @return array<string, mixed>
     */
    private function validateItem(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'cat' => ['nullable', 'string', 'max:255'],
            'price' => ['nullable', 'integer', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'emoji' => ['nullable', 'string', 'max:16'],
            'discount_type' => ['nullable', Rule::in(['percent', 'amount'])],
            'discount_value' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    /**
     * Normalize the discount input. A missing type clears the discount; a
     * percentage above 100 is rejected.
     *
     * @param  array<string, mixed>  $validated
     * @return array{discount_type: ?string, discount_value: int}
     */
    private function discountFrom(array $validated): array
    {
        $type = $validated['discount_type'] ?? null;
        $value = (int) ($validated['discount_value'] ?? 0);

        if ($type === null) {
            return ['discount_type' => null, 'discount_value' => 0];
        }

        if ($type === 'percent' && $value > 100) {
            throw ValidationException::withMessages([
                'discount_value' => ['Percentage discount cannot exceed 100%.'],
            ]);
        }

        return ['discount_type' => $type, 'discount_value' => $value];
    }

    /**
     * Resolve a category name to an active category id within the unit.
     * Returns null when no name is supplied or it does not match a category.
     */
    private function resolveCategoryId(string $unit, ?string $name): ?int
    {
        $name = $name !== null ? trim($name) : '';

        if ($name === '') {
            return null;
        }

        return Category::forUnit($unit)->where('name', $name)->value('id');
    }
}
