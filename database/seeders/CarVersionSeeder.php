<?php

namespace Database\Seeders;

use App\Models\CarVersion;
use Illuminate\Database\Seeder;

class CarVersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CarVersion::factory()
            ->count(5)
            ->create();
    }
}
