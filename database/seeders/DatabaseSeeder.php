<?php

namespace Database\Seeders;

use App\Enums\UserRole;
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
            'name' => 'Admin User',
            'email' => 'admin1@gmail.com',
            'role' => UserRole::ADMIN,
            'password' => bcrypt('passer'),
        ]);
        // php artisan db:seed

        $this->call([
            RssSourceSeeder::class,
        ]);
    }
}
