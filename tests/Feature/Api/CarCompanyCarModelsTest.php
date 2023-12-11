<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\CarModel;
use App\Models\CarCompany;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarCompanyCarModelsTest extends TestCase
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
    public function it_gets_car_company_car_models(): void
    {
        $carCompany = CarCompany::factory()->create();
        $carModels = CarModel::factory()
            ->count(2)
            ->create([
                'car_company_id' => $carCompany->id,
            ]);

        $response = $this->getJson(
            route('api.car-companies.car-models.index', $carCompany)
        );

        $response->assertOk()->assertSee($carModels[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_car_company_car_models(): void
    {
        $carCompany = CarCompany::factory()->create();
        $data = CarModel::factory()
            ->make([
                'car_company_id' => $carCompany->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.car-companies.car-models.store', $carCompany),
            $data
        );

        $this->assertDatabaseHas('car_models', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $carModel = CarModel::latest('id')->first();

        $this->assertEquals($carCompany->id, $carModel->car_company_id);
    }
}
