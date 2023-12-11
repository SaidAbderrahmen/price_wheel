<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\CarVersion;

use App\Models\CarModel;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarVersionControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_car_versions(): void
    {
        $carVersions = CarVersion::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('car-versions.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.car_versions.index')
            ->assertViewHas('carVersions');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_car_version(): void
    {
        $response = $this->get(route('car-versions.create'));

        $response->assertOk()->assertViewIs('app.car_versions.create');
    }

    /**
     * @test
     */
    public function it_stores_the_car_version(): void
    {
        $data = CarVersion::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('car-versions.store'), $data);

        $this->assertDatabaseHas('car_versions', $data);

        $carVersion = CarVersion::latest('id')->first();

        $response->assertRedirect(route('car-versions.edit', $carVersion));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_car_version(): void
    {
        $carVersion = CarVersion::factory()->create();

        $response = $this->get(route('car-versions.show', $carVersion));

        $response
            ->assertOk()
            ->assertViewIs('app.car_versions.show')
            ->assertViewHas('carVersion');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_car_version(): void
    {
        $carVersion = CarVersion::factory()->create();

        $response = $this->get(route('car-versions.edit', $carVersion));

        $response
            ->assertOk()
            ->assertViewIs('app.car_versions.edit')
            ->assertViewHas('carVersion');
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

        $response = $this->put(
            route('car-versions.update', $carVersion),
            $data
        );

        $data['id'] = $carVersion->id;

        $this->assertDatabaseHas('car_versions', $data);

        $response->assertRedirect(route('car-versions.edit', $carVersion));
    }

    /**
     * @test
     */
    public function it_deletes_the_car_version(): void
    {
        $carVersion = CarVersion::factory()->create();

        $response = $this->delete(route('car-versions.destroy', $carVersion));

        $response->assertRedirect(route('car-versions.index'));

        $this->assertModelMissing($carVersion);
    }
}
