<?php

namespace Database\Seeders;

use App\Models\CarCompany;
use Illuminate\Database\Seeder;

class CarCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CarCompany::factory()
            ->count(5)
            ->create();
    }
}
