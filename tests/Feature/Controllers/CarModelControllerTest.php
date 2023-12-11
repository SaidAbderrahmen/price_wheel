<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\CarModel;

use App\Models\CarCompany;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarModelControllerTest extends TestCase
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
    public function it_displays_index_view_with_car_models(): void
    {
        $carModels = CarModel::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('car-models.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.car_models.index')
            ->assertViewHas('carModels');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_car_model(): void
    {
        $response = $this->get(route('car-models.create'));

        $response->assertOk()->assertViewIs('app.car_models.create');
    }

    /**
     * @test
     */
    public function it_stores_the_car_model(): void
    {
        $data = CarModel::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('car-models.store'), $data);

        $this->assertDatabaseHas('car_models', $data);

        $carModel = CarModel::latest('id')->first();

        $response->assertRedirect(route('car-models.edit', $carModel));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_car_model(): void
    {
        $carModel = CarModel::factory()->create();

        $response = $this->get(route('car-models.show', $carModel));

        $response
            ->assertOk()
            ->assertViewIs('app.car_models.show')
            ->assertViewHas('carModel');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_car_model(): void
    {
        $carModel = CarModel::factory()->create();

        $response = $this->get(route('car-models.edit', $carModel));

        $response
            ->assertOk()
            ->assertViewIs('app.car_models.edit')
            ->assertViewHas('carModel');
    }

    /**
     * @test
     */
    public function it_updates_the_car_model(): void
    {
        $carModel = CarModel::factory()->create();

        $carCompany = CarCompany::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'car_company_id' => $carCompany->id,
        ];

        $response = $this->put(route('car-models.update', $carModel), $data);

        $data['id'] = $carModel->id;

        $this->assertDatabaseHas('car_models', $data);

        $response->assertRedirect(route('car-models.edit', $carModel));
    }

    /**
     * @test
     */
    public function it_deletes_the_car_model(): void
    {
        $carModel = CarModel::factory()->create();

        $response = $this->delete(route('car-models.destroy', $carModel));

        $response->assertRedirect(route('car-models.index'));

        $this->assertModelMissing($carModel);
    }
}
