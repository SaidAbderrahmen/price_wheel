<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);

        $this->call(CarCompanySeeder::class);
        $this->call(CarModelSeeder::class);
        $this->call(CarOptionSeeder::class);
        $this->call(CarVersionSeeder::class);
        $this->call(UserSeeder::class);
    }
}
