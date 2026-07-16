<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Member;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PosController extends Controller
{
    /**
     * Show the single-page POS application.
     *
     * Catalog items and categories for every unit are sourced from the database
     * (the manager-managed CRUD layer). Gym members are merged from the database
     * (real accounts) on top of the JSON prototype members so registered /
     * admin-created members appear in the list.
     */
    public function index(Request $request)
    {
        $units = collect(['gym', 'store', 'kitchen'])
            ->mapWithKeys(fn (string $unit) => [$unit => [
                'categories' => Category::forUnit($unit)
                    ->orderBy('name')
                    ->get()
                    ->map(fn (Category $c) => $c->toPosArray())
                    ->all(),
                'catalog' => Product::forUnit($unit)
                    ->with('category')
                    ->orderBy('id')
                    ->get()
                    ->map(fn (Product $p) => $p->toPosArray())
                    ->all(),
            ]])
            ->all();

        // Gym members = DB accounts on top of the JSON prototype members.
        $dbMembers = Member::with('user')
            ->latest('id')
            ->get()
            ->map(fn (Member $m) => $m->toPosArray())
            ->all();

        $units['gym']['members'] = array_merge($dbMembers, $this->seedMembers());

        return view('pos.index', [
            'units' => $units,
            'role' => $request->user()->role,
        ]);
    }

    /**
     * Read the prototype gym members still shipped in the JSON seed file.
     *
     * @return array<int, array<string, mixed>>
     */
    private function seedMembers(): array
    {
        $path = resource_path('data/gym.json');

        if (! File::exists($path)) {
            return [];
        }

        $data = json_decode(File::get($path), true);

        return is_array($data['members'] ?? null) ? $data['members'] : [];
    }
}
