<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PosController extends Controller
{
    /**
     * Show the single-page POS application.
     *
     * Phase 1 (prototype): initial catalog data is read from JSON files and
     * passed to the Blade view via @json. The relational DB + CRUD layer is
     * added in a later phase.
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

        return view('pos.index', [
            'units' => $units,
            'role' => $request->user()->role,
        ]);
    }
}
