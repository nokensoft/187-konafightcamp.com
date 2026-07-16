<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CatalogSeeder extends Seeder
{
    /**
     * The POS units whose catalog/categories are seeded from JSON.
     *
     * @var list<string>
     */
    private const UNITS = ['gym', 'store', 'kitchen'];

    /**
     * Import the prototype categories + catalog items from the JSON seed files
     * into the database. Idempotent: re-running will not create duplicates.
     */
    public function run(): void
    {
        foreach (self::UNITS as $unit) {
            $data = $this->readUnit($unit);

            $categoryIds = $this->seedCategories($unit, $data['categories'] ?? []);
            $this->seedProducts($unit, $data['catalog'] ?? [], $categoryIds);
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function readUnit(string $unit): array
    {
        $path = resource_path("data/{$unit}.json");

        if (! File::exists($path)) {
            return [];
        }

        return json_decode(File::get($path), true) ?: [];
    }

    /**
     * Create the unit's categories and return a name => id map.
     *
     * @param  array<int, mixed>  $categories
     * @return array<string, int>
     */
    private function seedCategories(string $unit, array $categories): array
    {
        $map = [];

        foreach ($categories as $category) {
            $name = is_array($category) ? ($category['name'] ?? null) : $category;

            if (! $name) {
                continue;
            }

            $model = Category::firstOrCreate(
                ['unit' => $unit, 'name' => $name],
                ['description' => is_array($category) ? ($category['description'] ?? null) : null],
            );

            $map[$name] = $model->id;
        }

        return $map;
    }

    /**
     * Create the unit's catalog items, linking each to its category.
     *
     * @param  array<int, array<string, mixed>>  $catalog
     * @param  array<string, int>  $categoryIds
     */
    private function seedProducts(string $unit, array $catalog, array $categoryIds): void
    {
        foreach ($catalog as $item) {
            if (empty($item['name'])) {
                continue;
            }

            $categoryName = $item['cat'] ?? null;

            // Fall back to creating a category if an item references one that
            // was not listed under "categories".
            if ($categoryName && ! isset($categoryIds[$categoryName])) {
                $categoryIds[$categoryName] = Category::firstOrCreate(
                    ['unit' => $unit, 'name' => $categoryName],
                )->id;
            }

            Product::firstOrCreate(
                ['unit' => $unit, 'name' => $item['name']],
                [
                    'category_id' => $categoryName ? ($categoryIds[$categoryName] ?? null) : null,
                    'price' => (int) ($item['price'] ?? 0),
                    'stock' => (int) ($item['stock'] ?? 0),
                    'emoji' => $item['emoji'] ?? null,
                ],
            );
        }
    }
}
