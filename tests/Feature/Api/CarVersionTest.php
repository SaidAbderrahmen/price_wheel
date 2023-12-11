<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\CarVersion;

use App\Models\CarModel;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarVersionTest extends TestCase
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
    public function it_gets_car_versions_list(): void
    {
        $carVersions = CarVersion::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.car-versions.index'));

        $response->assertOk()->assertSee($carVersions[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_car_version(): void
    {
        $data = CarVersion::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.car-versions.store'), $data);

        $this->assertDatabaseHas('car_versions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_car_version(): void
    {
        $carVersion = CarVersion::factory()->create();

        $carModel = CarModel::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'year' => $this->faker->year(),
            'initial_price' => $this->faker->randomNumber(1),
            'car_model_id' => $carModel->id,
        ];

        $response = $this->putJson(
            route('api.car-versions.update', $carVersion),
            $data
        );

        $data['id'] = $carVersion->id;

        $this->assertDatabaseHas('car_versions', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_car_version(): void
    {
        $carVersion = CarVersion::factory()->create();

        $response = $this->deleteJson(
            route('api.car-versions.destroy', $carVersion)
        );

        $this->assertModelMissing($carVersion);

        $response->assertNoContent();
    }
}
