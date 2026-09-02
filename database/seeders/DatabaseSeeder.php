<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $superadminRole = Role::firstOrCreate(['name' => 'Superadmin']);
        Role::firstOrCreate(['name' => 'DDSDCE Office']);
        Role::firstOrCreate(['name' => 'DDAA Office']);
        Role::firstOrCreate(['name' => 'DD']);

        $superadmin = User::firstOrCreate(
            ['email' => 'admin@kict.iium.edu.my'],
            [
                'name' => 'KICT Superadmin',
                'password' => 'password',
            ]
        );

        $superadmin->assignRole($superadminRole);

        $this->call(ReferenceDataSeeder::class);
    }
}
