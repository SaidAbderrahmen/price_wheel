<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\CarModel;
use App\Models\CarVersion;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarModelCarVersionsTest extends TestCase
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
    public function it_gets_car_model_car_versions(): void
    {
        $carModel = CarModel::factory()->create();
        $carVersions = CarVersion::factory()
            ->count(2)
            ->create([
                'car_model_id' => $carModel->id,
            ]);

        $response = $this->getJson(
            route('api.car-models.car-versions.index', $carModel)
        );

        $response->assertOk()->assertSee($carVersions[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_car_model_car_versions(): void
    {
        $carModel = CarModel::factory()->create();
        $data = CarVersion::factory()
            ->make([
                'car_model_id' => $carModel->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.car-models.car-versions.store', $carModel),
            $data
        );

        $this->assertDatabaseHas('car_versions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $carVersion = CarVersion::latest('id')->first();

        $this->assertEquals($carModel->id, $carVersion->car_model_id);
    }
}
