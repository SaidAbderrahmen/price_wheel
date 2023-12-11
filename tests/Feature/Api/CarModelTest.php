<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\CarModel;

use App\Models\CarCompany;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarModelTest extends TestCase
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
    public function it_gets_car_models_list(): void
    {
        $carModels = CarModel::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.car-models.index'));

        $response->assertOk()->assertSee($carModels[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_car_model(): void
    {
        $data = CarModel::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.car-models.store'), $data);

        $this->assertDatabaseHas('car_models', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.car-models.update', $carModel),
            $data
        );

        $data['id'] = $carModel->id;

        $this->assertDatabaseHas('car_models', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_car_model(): void
    {
        $carModel = CarModel::factory()->create();

        $response = $this->deleteJson(
            route('api.car-models.destroy', $carModel)
        );

        $this->assertModelMissing($carModel);

        $response->assertNoContent();
    }
}
