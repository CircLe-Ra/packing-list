<?php

namespace Database\Seeders;

use App\Models\Consumer;
use App\Models\Container;
use App\Models\Driver;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'driver',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'leader',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'fieldagen',
            'guard_name' => 'web',
        ]);

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ])->assignRole('admin');

        User::factory()->create([
            'name' => fake()->name(),
            'email' => 'driver@driver.com',
            'password' => bcrypt('driver'),
        ])->assignRole('driver');

        User::factory()->create([
            'name' => fake()->name(),
            'email' => 'leader@leader.com',
            'password' => bcrypt('leader'),
        ])->assignRole('leader');

        User::factory()->create([
            'name' => fake()->name(),
            'email' => 'fieldagen@fieldagen.com',
            'password' => bcrypt('fieldagen'),
        ])->assignRole('fieldagen');

        Consumer::factory()->count(10)->create();
        Driver::factory()->count(10)->create();
        Container::factory()->count(10)->create();
    }
}
