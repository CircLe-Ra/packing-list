<?php

namespace Database\Seeders;

use App\Models\Consumer;
use App\Models\Container;
use App\Models\Driver;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ]);

        Consumer::factory()->count(10)->create();
        Driver::factory()->count(10)->create();
        Container::factory()->count(10)->create();
    }
}
