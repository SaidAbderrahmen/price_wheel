<?php

namespace Database\Factories;

use App\Models\CarModel;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CarModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'car_company_id' => \App\Models\CarCompany::factory(),
        ];
    }
}
