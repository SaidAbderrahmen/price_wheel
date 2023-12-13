<?php

namespace Database\Seeders;

use App\Models\CarOption;
use Illuminate\Database\Seeder;

class CarOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CarOption::factory()
            ->count(5)
            ->create();
    }
}
