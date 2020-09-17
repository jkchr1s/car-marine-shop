<?php

namespace Tests\Feature;

use App\User;
use App\Vehicle;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // seed customer types
        $this->seed('CustomerTypeTableSeeder');

        // create mock user
        $this->user = User::factory()->create();

        // create mock vehicle
        $this->vehicle = Vehicle::factory()->create();

        $this->faker = Factory::create();
    }

    public function testIndex()
    {
        // check unauthenticated
        $this->get(route('vehicle.index'))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // check authenticated
        $this->actingAs($this->user)
            ->get(route('vehicle.index'))
            ->assertStatus(501);
    }

    public function testCreate()
    {
        // unauth redirect to login
        $this->get(route('vehicle.create'))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // should redirect because no customer_id was set
        $this->actingAs($this->user)
            ->get(route('vehicle.create'))
            ->assertStatus(302);

        // should succeed
        $this->actingAs($this->user)
            ->get(route('vehicle.create', ['customer_id' => $this->vehicle->customer_id]))
            ->assertStatus(200);
    }

    public function testStore()
    {
        // create mock object
        $vehicle = Vehicle::factory()->make()->getAttributes();

        // unauthed
        $response = $this->json('POST', route('vehicle.store'), $vehicle)
            ->assertStatus(401);
        $this->assertDatabaseMissing('vehicles', $vehicle);

        // authed
        $response = $this->actingAs($this->user)
            ->json('POST', route('vehicle.store'), $vehicle)
            ->assertStatus(302)
            ->assertRedirect(route('customer.show', $vehicle['customer_id']));
        $this->assertDatabaseHas('vehicles', $vehicle);
    }

    public function testShow()
    {
        // unauth redirect to login
        $this->get(route('vehicle.show', $this->vehicle->id))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // authed
        $response = $this->actingAs($this->user)
            ->get(route('vehicle.show', $this->vehicle->id))
            ->assertStatus(200);

        // check output
        $response->assertSee($this->vehicle->make->make)
            ->assertSee($this->vehicle->model->model)
            ->assertSee($this->vehicle->year);
    }

    public function testEdit()
    {
        // unauth redirect to login
        $this->get(route('vehicle.edit', $this->vehicle->id))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // authed
        $this->actingAs($this->user)
            ->get(route('vehicle.edit', $this->vehicle->id))
            ->assertStatus(501);
    }

    public function testUpdate()
    {
        // create mock object
        $target = Vehicle::factory()->create();
        $update = Vehicle::factory()->make()->getAttributes();

        // unauth redirect to login
        $this->json('PUT', route('vehicle.update', $target->id), $update)
            ->assertStatus(401);

        // authed
        $this->actingAs($this->user)
            ->json('PUT', route('vehicle.update', $target->id), $update)
            ->assertStatus(501);
    }

    public function testDestroy()
    {
        $toDel = Vehicle::factory()->create();

        // unauth redirect to login
        $this->delete(route('vehicle.destroy', $toDel->id))
            ->assertStatus(302)
            ->assertRedirect('/login');
        $this->assertDatabaseHas('vehicles', $toDel->getAttributes());

        // authed
        $this->actingAs($this->user)
            ->delete(route('vehicle.destroy', $toDel->id))
            ->assertStatus(302)
            ->assertRedirect(route('customer.show', $toDel->customer_id));
        $this->assertDatabaseMissing('vehicles', $toDel->getAttributes());
    }
}
