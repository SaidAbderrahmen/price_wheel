<?php

namespace Database\Factories;

use App\Models\CarOption;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CarOption::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(10),
            'description' => $this->faker->sentence(15),
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'car_version_id' => \App\Models\CarVersion::factory(),
        ];
    }
}
