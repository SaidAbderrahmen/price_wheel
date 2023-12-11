<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\CarOption;

use App\Models\CarVersion;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarOptionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_car_options_list(): void
    {
        $carOptions = CarOption::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.car-options.index'));

        $response->assertOk()->assertSee($carOptions[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_car_option(): void
    {
        $data = CarOption::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.car-options.store'), $data);

        $this->assertDatabaseHas('car_options', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_car_option(): void
    {
        $carOption = CarOption::factory()->create();

        $carVersion = CarVersion::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'description' => $this->faker->sentence(15),
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'car_version_id' => $carVersion->id,
        ];

        $response = $this->putJson(
            route('api.car-options.update', $carOption),
            $data
        );

        $data['id'] = $carOption->id;

        $this->assertDatabaseHas('car_options', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_car_option(): void
    {
        $carOption = CarOption::factory()->create();

        $response = $this->deleteJson(
            route('api.car-options.destroy', $carOption)
        );

        $this->assertModelMissing($carOption);

        $response->assertNoContent();
    }
}
