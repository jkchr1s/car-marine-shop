<?php

namespace Tests\Feature;

use App\User;
use App\VehicleModel;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleModelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // seed customer types
        $this->seed('CustomerTypeTableSeeder');

        // create mock user
        $this->user = User::factory()->create();

        // create mock vehicle make
        $this->model = VehicleModel::factory()->create();

        $this->faker = Factory::create();
    }

    public function testIndex()
    {
        // check unauthenticated
        $this->get(route('vehicle_model.index'))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // check authenticated
        $this->actingAs($this->user)
            ->get(route('vehicle_model.index'))
            ->assertStatus(200)
            ->assertSee($this->model->model);
    }

    public function testCreate()
    {
        // unauth redirect to login
        $this->get(route('vehicle_model.create'))
            ->assertStatus(302)
            ->assertRedirect('/login');

        $this->actingAs($this->user)
            ->get(route('vehicle_model.create'))
            ->assertStatus(501);
    }

    public function testStore()
    {
        // create mock object
        $make = VehicleModel::factory()->make()->getAttributes();

        // unauthed
        $response = $this->json('POST', route('vehicle_model.store'), $make)
            ->assertStatus(401);
        $this->assertDatabaseMissing('vehicle_models', $make);

        // authed
        $response = $this->actingAs($this->user)
            ->json('POST', route('vehicle_model.store'), $make)
            ->assertStatus(302);
        $this->assertDatabaseHas('vehicle_models', $make);
    }

    public function testShow()
    {
        // unauth redirect to login
        $this->get(route('vehicle_model.show', $this->model->id))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // authed
        $response = $this->actingAs($this->user)
            ->get(route('vehicle_model.show', $this->model->id))
            ->assertStatus(501);
    }

    public function testEdit()
    {
        // unauth redirect to login
        $this->get(route('vehicle_model.edit', $this->model->id))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // authed
        $this->actingAs($this->user)
            ->get(route('vehicle_model.edit', $this->model->id))
            ->assertStatus(501);
    }

    public function testUpdate()
    {
        // create mock object
        $target = VehicleModel::factory()->create();
        $update = VehicleModel::factory()->make()->getAttributes();

        // unauth redirect to login
        $this->json('PUT', route('vehicle_model.update', $target->id), $update)
            ->assertStatus(401);
        $this->assertDatabaseMissing('vehicle_models', $update);

        // authed
        $this->actingAs($this->user)
            ->json('PUT', route('vehicle_model.update', $target->id), $update)
            ->assertStatus(501);
    }

    public function testDestroy()
    {
        $toDel = VehicleModel::factory()->create();

        // unauth redirect to login
        $this->delete(route('vehicle_model.destroy', $toDel->id))
            ->assertStatus(302)
            ->assertRedirect('/login');
        $this->assertDatabaseHas('vehicle_models', $toDel->getAttributes());

        // authed
        $this->actingAs($this->user)
            ->delete(route('vehicle_model.destroy', $toDel->id))
            ->assertStatus(302)
            ->assertRedirect(route('vehicle_model.index'));
        $this->assertDatabaseMissing('vehicle_models', $toDel->getAttributes());
    }
}
