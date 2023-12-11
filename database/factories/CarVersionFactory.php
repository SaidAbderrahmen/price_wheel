<?php

namespace Database\Factories;

use App\Models\CarVersion;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarVersionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CarVersion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'year' => $this->faker->year(),
            'initial_price' => $this->faker->randomNumber(1),
            'car_model_id' => \App\Models\CarModel::factory(),
        ];
    }
}
