<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\CarCompany;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarCompanyTest extends TestCase
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
    public function it_gets_car_companies_list(): void
    {
        $carCompanies = CarCompany::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.car-companies.index'));

        $response->assertOk()->assertSee($carCompanies[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_car_company(): void
    {
        $data = CarCompany::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.car-companies.store'), $data);

        $this->assertDatabaseHas('car_companies', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.car-companies.update', $carCompany),
            $data
        );

        $data['id'] = $carCompany->id;

        $this->assertDatabaseHas('car_companies', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_car_company(): void
    {
        $carCompany = CarCompany::factory()->create();

        $response = $this->deleteJson(
            route('api.car-companies.destroy', $carCompany)
        );

        $this->assertModelMissing($carCompany);

        $response->assertNoContent();
    }
}
