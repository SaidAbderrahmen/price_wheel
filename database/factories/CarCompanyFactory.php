<?php

namespace Database\Factories;

use App\Models\CarCompany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarCompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CarCompany::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'logo' => $this->faker->text(255),
        ];
    }
}
