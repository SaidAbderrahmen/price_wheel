<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\CarOption;

use App\Models\CarVersion;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarOptionControllerTest extends TestCase
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
    public function it_displays_index_view_with_car_options(): void
    {
        $carOptions = CarOption::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('car-options.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.car_options.index')
            ->assertViewHas('carOptions');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_car_option(): void
    {
        $response = $this->get(route('car-options.create'));

        $response->assertOk()->assertViewIs('app.car_options.create');
    }

    /**
     * @test
     */
    public function it_stores_the_car_option(): void
    {
        $data = CarOption::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('car-options.store'), $data);

        $this->assertDatabaseHas('car_options', $data);

        $carOption = CarOption::latest('id')->first();

        $response->assertRedirect(route('car-options.edit', $carOption));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_car_option(): void
    {
        $carOption = CarOption::factory()->create();

        $response = $this->get(route('car-options.show', $carOption));

        $response
            ->assertOk()
            ->assertViewIs('app.car_options.show')
            ->assertViewHas('carOption');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_car_option(): void
    {
        $carOption = CarOption::factory()->create();

        $response = $this->get(route('car-options.edit', $carOption));

        $response
            ->assertOk()
            ->assertViewIs('app.car_options.edit')
            ->assertViewHas('carOption');
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

        $response = $this->put(route('car-options.update', $carOption), $data);

        $data['id'] = $carOption->id;

        $this->assertDatabaseHas('car_options', $data);

        $response->assertRedirect(route('car-options.edit', $carOption));
    }

    /**
     * @test
     */
    public function it_deletes_the_car_option(): void
    {
        $carOption = CarOption::factory()->create();

        $response = $this->delete(route('car-options.destroy', $carOption));

        $response->assertRedirect(route('car-options.index'));

        $this->assertModelMissing($carOption);
    }
}
