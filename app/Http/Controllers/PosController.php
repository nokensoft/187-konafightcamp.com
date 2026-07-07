<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PosController extends Controller
{
    /**
     * Show the single-page POS application.
     *
     * Phase 1 (prototype): catalog/category data is read from JSON files. Gym
     * members are merged from the database (real accounts) on top of the JSON
     * seed members so registered / admin-created members appear in the list.
     */
    public function index(Request $request)
    {
        $units = collect(['gym', 'store', 'kitchen'])
            ->mapWithKeys(function (string $unit) {
                $path = resource_path("data/{$unit}.json");

                $data = File::exists($path)
                    ? json_decode(File::get($path), true)
                    : null;

                return [$unit => $data];
            })
            ->all();

        if (is_array($units['gym'] ?? null)) {
            $dbMembers = Member::with('user')
                ->latest('id')
                ->get()
                ->map(fn (Member $m) => $m->toPosArray())
                ->all();

            $units['gym']['members'] = array_merge($dbMembers, $units['gym']['members'] ?? []);
        }

        return view('pos.index', [
            'units' => $units,
            'role' => $request->user()->role,
        ]);
    }
}
