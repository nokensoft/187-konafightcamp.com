<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * The POS units a category can belong to.
     *
     * @var list<string>
     */
    private const UNITS = ['gym', 'store', 'kitchen'];

    /**
     * Create a category for the given unit and return it in the POS shape.
     */
    public function store(Request $request, string $unit): JsonResponse
    {
        abort_unless(in_array($unit, self::UNITS, true), 404);

        $validated = $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                $this->uniqueNameRule($unit),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $category = Category::create([
            'unit' => $unit,
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json(['category' => $category->toPosArray()], 201);
    }

    /**
     * Update a category (rename / edit description). Because items link by
     * foreign key, a rename requires no changes to the item rows.
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $validated = $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                $this->uniqueNameRule($category->unit, $category->id),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $category->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json(['category' => $category->toPosArray()]);
    }

    /**
     * Delete a category. Refused (422) while it still has active items, so
     * catalog rows are never silently orphaned.
     */
    public function destroy(Category $category): JsonResponse
    {
        if ($category->products()->exists()) {
            throw ValidationException::withMessages([
                'category' => ['Move or delete its items before deleting this category.'],
            ]);
        }

        $category->delete();

        return response()->json(['ok' => true]);
    }

    /**
     * Rule ensuring the name is unique among active categories in the unit.
     */
    private function uniqueNameRule(string $unit, ?int $ignoreId = null): Unique
    {
        $rule = Rule::unique('categories', 'name')
            ->where(fn ($query) => $query->where('unit', $unit)->whereNull('deleted_at'));

        return $ignoreId ? $rule->ignore($ignoreId) : $rule;
    }
}
