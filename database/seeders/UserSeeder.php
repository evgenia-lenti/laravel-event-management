<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Simple users
        User::factory(50)->create();

        // Admin users
        User::factory()->admin()->create([
            'name' => 'Evgenia Lenti',
            'email' => 'evgenia@lenti.com'
        ]);

        User::factory()->admin()->create([
            'name' => 'Nikos Ioannidis',
            'email' => 'nikos@ioannidis.com'
        ]);
    }
}
