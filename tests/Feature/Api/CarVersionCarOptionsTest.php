<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\CarOption;
use App\Models\CarVersion;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarVersionCarOptionsTest extends TestCase
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
    public function it_gets_car_version_car_options(): void
    {
        $carVersion = CarVersion::factory()->create();
        $carOptions = CarOption::factory()
            ->count(2)
            ->create([
                'car_version_id' => $carVersion->id,
            ]);

        $response = $this->getJson(
            route('api.car-versions.car-options.index', $carVersion)
        );

        $response->assertOk()->assertSee($carOptions[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_car_version_car_options(): void
    {
        $carVersion = CarVersion::factory()->create();
        $data = CarOption::factory()
            ->make([
                'car_version_id' => $carVersion->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.car-versions.car-options.store', $carVersion),
            $data
        );

        $this->assertDatabaseHas('car_options', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $carOption = CarOption::latest('id')->first();

        $this->assertEquals($carVersion->id, $carOption->car_version_id);
    }
}
