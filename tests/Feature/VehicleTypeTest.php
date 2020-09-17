<?php

namespace Tests\Feature;

use App\User;
use App\VehicleType;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleTypeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // seed customer types
        $this->seed('CustomerTypeTableSeeder');

        // create mock user
        $this->user = User::factory()->create();

        // create mock vehicle type
        $this->vehicleType = VehicleType::factory()->create();

        $this->faker = Factory::create();
    }

    public function testIndex()
    {
        // check unauthenticated
        $this->get(route('vehicle_type.index'))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // check authenticated
        $this->actingAs($this->user)
            ->get(route('vehicle_type.index'))
            ->assertStatus(200)
            ->assertSee($this->vehicleType->type);
    }

    public function testCreate()
    {
        // unauth redirect to login
        $this->get(route('vehicle_type.create'))
            ->assertStatus(302)
            ->assertRedirect('/login');

        $this->actingAs($this->user)
            ->get(route('vehicle_type.create'))
            ->assertStatus(501);
    }

    public function testStore()
    {
        // create mock object
        $type = VehicleType::factory()->make()->getAttributes();

        // unauthed
        $response = $this->json('POST', route('vehicle_type.store'), $type)
            ->assertStatus(401);
        $this->assertDatabaseMissing('vehicle_types', $type);

        // authed
        $response = $this->actingAs($this->user)
            ->json('POST', route('vehicle_type.store'), $type)
            ->assertStatus(302)
            ->assertRedirect(route('vehicle_type.index'));
        $this->assertDatabaseHas('vehicle_types', $type);
    }

    public function testShow()
    {
        // unauth redirect to login
        $this->get(route('vehicle_type.show', $this->vehicleType->id))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // authed
        $response = $this->actingAs($this->user)
            ->get(route('vehicle_type.show', $this->vehicleType->id))
            ->assertStatus(501);
    }

    public function testEdit()
    {
        // unauth redirect to login
        $this->get(route('vehicle_type.edit', $this->vehicleType->id))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // authed
        $this->actingAs($this->user)
            ->get(route('vehicle_type.edit', $this->vehicleType->id))
            ->assertStatus(501);
    }

    public function testUpdate()
    {
        // create mock object
        $target = VehicleType::factory()->create();
        $update = VehicleType::factory()->make()->getAttributes();

        // unauth redirect to login
        $this->json('PUT', route('vehicle_type.update', $target->id), $update)
            ->assertStatus(401);
        $this->assertDatabaseMissing('vehicle_types', $update);

        // authed
        $this->actingAs($this->user)
            ->json('PUT', route('vehicle_type.update', $target->id), $update)
            ->assertStatus(302)
            ->assertRedirect(route('vehicle_type.index'));
        $this->assertDatabaseHas('vehicle_types',
            collect($update)
                ->filter(function ($value, $key) {
                    return $key !== 'created_at' && $key !== 'updated_at';
                })
                ->toArray()
        );
    }

    public function testDestroy()
    {
        $toDel = VehicleType::factory()->create();

        // unauth redirect to login
        $this->delete(route('vehicle_type.destroy', $toDel->id))
            ->assertStatus(302)
            ->assertRedirect('/login');
        $this->assertDatabaseHas('vehicle_types', $toDel->getAttributes());

        // authed
        $this->actingAs($this->user)
            ->delete(route('vehicle_type.destroy', $toDel->id))
            ->assertStatus(302)
            ->assertRedirect(route('vehicle_type.index'));
        $this->assertDatabaseMissing('vehicle_types', $toDel->getAttributes());
    }
}
