<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\CarCompany;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarCompanyControllerTest extends TestCase
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
    public function it_displays_index_view_with_car_companies(): void
    {
        $carCompanies = CarCompany::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('car-companies.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.car_companies.index')
            ->assertViewHas('carCompanies');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_car_company(): void
    {
        $response = $this->get(route('car-companies.create'));

        $response->assertOk()->assertViewIs('app.car_companies.create');
    }

    /**
     * @test
     */
    public function it_stores_the_car_company(): void
    {
        $data = CarCompany::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('car-companies.store'), $data);

        $this->assertDatabaseHas('car_companies', $data);

        $carCompany = CarCompany::latest('id')->first();

        $response->assertRedirect(route('car-companies.edit', $carCompany));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_car_company(): void
    {
        $carCompany = CarCompany::factory()->create();

        $response = $this->get(route('car-companies.show', $carCompany));

        $response
            ->assertOk()
            ->assertViewIs('app.car_companies.show')
            ->assertViewHas('carCompany');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_car_company(): void
    {
        $carCompany = CarCompany::factory()->create();

        $response = $this->get(route('car-companies.edit', $carCompany));

        $response
            ->assertOk()
            ->assertViewIs('app.car_companies.edit')
            ->assertViewHas('carCompany');
    }

    /**
     * @test
     */
    public function it_updates_the_car_company(): void
    {
        $carCompany = CarCompany::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'logo' => $this->faker->text(255),
        ];

        $response = $this->put(
            route('car-companies.update', $carCompany),
            $data
        );

        $data['id'] = $carCompany->id;

        $this->assertDatabaseHas('car_companies', $data);

        $response->assertRedirect(route('car-companies.edit', $carCompany));
    }

    /**
     * @test
     */
    public function it_deletes_the_car_company(): void
    {
        $carCompany = CarCompany::factory()->create();

        $response = $this->delete(route('car-companies.destroy', $carCompany));

        $response->assertRedirect(route('car-companies.index'));

        $this->assertModelMissing($carCompany);
    }
}
