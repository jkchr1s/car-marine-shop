<?php

namespace Tests\Feature;

use App\User;
use App\VehicleMake;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VehicleMakeTest extends TestCase
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
        $this->make = VehicleMake::factory()->create();

        $this->faker = Factory::create();
    }

    public function testIndex()
    {
        // check unauthenticated
        $this->get(route('vehicle_make.index'))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // check authenticated
        $this->actingAs($this->user)
            ->get(route('vehicle_make.index'))
            ->assertStatus(200)
            ->assertSee($this->make->make)
            ->assertSee('Showing All Vehicle Types');

        $this->actingAs($this->user)
            ->get(route('vehicle_make.index', ['type' => $this->make->vehicle_type_id]))
            ->assertStatus(200)
            ->assertSee($this->make->make)
            ->assertSee('Showing '.$this->make->vehicle_type->type);
    }

    public function testCreate()
    {
        // unauth redirect to login
        $this->get(route('vehicle_make.create'))
            ->assertStatus(302)
            ->assertRedirect('/login');

        $this->actingAs($this->user)
            ->get(route('vehicle_make.create'))
            ->assertStatus(501);
    }

    public function testStore()
    {
        // create mock object
        $make = VehicleMake::factory()->make()->getAttributes();

        // unauthed
        $response = $this->json('POST', route('vehicle_make.store'), $make)
            ->assertStatus(401);
        $this->assertDatabaseMissing('vehicle_makes', $make);

        // authed
        $response = $this->actingAs($this->user)
            ->json('POST', route('vehicle_make.store'), $make)
            ->assertStatus(302);
        $this->assertDatabaseHas('vehicle_makes', $make);
    }

    public function testShow()
    {
        // unauth redirect to login
        $this->get(route('vehicle_make.show', $this->make->id))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // authed
        $response = $this->actingAs($this->user)
            ->get(route('vehicle_make.show', $this->make->id))
            ->assertStatus(501);
    }

    public function testEdit()
    {
        // unauth redirect to login
        $this->get(route('vehicle_make.edit', $this->make->id))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // authed
        $this->actingAs($this->user)
            ->get(route('vehicle_make.edit', $this->make->id))
            ->assertStatus(501);
    }

    public function testUpdate()
    {
        // create mock object
        $target = VehicleMake::factory()->create();
        $update = [
            'make' => $this->faker->company(),
        ];

        // unauth redirect to login
        $this->json('PUT', route('vehicle_make.update', $target->id), $update)
            ->assertStatus(401);
        $this->assertDatabaseMissing('vehicle_makes', $update);

        // authed
        $this->actingAs($this->user)
            ->json('PUT', route('vehicle_make.update', $target->id), $update)
            ->assertStatus(302)
            ->assertRedirect(route('vehicle_make.index'));
        $this->assertDatabaseHas('vehicle_makes',
            collect($update)
                ->filter(function ($value, $key) {
                    return $key !== 'created_at' && $key !== 'updated_at';
                })
                ->toArray()
        );
    }

    public function testDestroy()
    {
        $toDel = VehicleMake::factory()->create();

        // unauth redirect to login
        $this->delete(route('vehicle_make.destroy', $toDel->id))
            ->assertStatus(302)
            ->assertRedirect('/login');
        $this->assertDatabaseHas('vehicle_makes', $toDel->getAttributes());

        // authed
        $this->actingAs($this->user)
            ->delete(route('vehicle_make.destroy', $toDel->id))
            ->assertStatus(302)
            ->assertRedirect(route('vehicle_make.index'));
        $this->assertDatabaseMissing('vehicle_makes', $toDel->getAttributes());
    }
}
