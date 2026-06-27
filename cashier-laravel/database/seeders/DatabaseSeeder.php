<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->manager()->create([
            'name' => 'Manager',
            'email' => 'manager@kfc.test',
        ]);

        User::factory()->create([
            'name' => 'Cashier',
            'email' => 'cashier@kfc.test',
        ]);

        User::factory()->member()->create([
            'name' => 'Member',
            'email' => 'member@kfc.test',
        ]);
    }
}
