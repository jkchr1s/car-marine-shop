<?php

namespace Tests\Feature;

use App\Location;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // seed customer types
        $this->seed('CustomerTypeTableSeeder');

        // create mock user
        $this->user = User::factory()->create();

        // create mock location
        $this->location = Location::factory()->create();

        // mock customer
        $this->customer = $this->location->customer;

        // mock location type
        $this->locationType = $this->location->location_type;

        $this->faker = Factory::create();
    }

    public function testIndex()
    {
        // check unauthenticated
        $this->get(route('location.index'))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // check authenticated
        $response = $this->actingAs($this->user)
            ->get(route('location.index'))
            ->assertStatus(501);
    }

    public function testCreate()
    {
        // unauth redirect to login
        $this->get(route('location.create'))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // authed should get too
        $this->actingAs($this->user)
            ->get(route('location.create'))
            ->assertStatus(501);
    }

    public function testStore()
    {
        // create mock customer
        $location = [
            'customer_id' => $this->customer->id,
            'location_type_id' => $this->locationType->id,
            'address1' => $this->faker->streetAddress(),
            'address2' => $this->faker->secondaryAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->stateAbbr(),
            'zip' => $this->faker->postcode(),
        ];

        // unauthed
        $response = $this->json('POST', route('location.store'), $location)
            ->assertStatus(401);
        $this->assertDatabaseMissing('locations', $location);

        // authed
        $response = $this->actingAs($this->user)
            ->json('POST', route('location.store'), $location)
            ->assertStatus(302);
        $this->assertDatabaseHas('locations', $location);
    }

    public function testShow()
    {
        // unauth redirect to login
        $this->get(route('location.show', $this->location->id))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // authed
        $response = $this->actingAs($this->user)
            ->get(route('location.show', $this->location->id))
            ->assertStatus(501);
    }

    public function testEdit()
    {
        // unauth redirect to login
        $this->get(route('location.edit', $this->location->id))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // authed
        $this->actingAs($this->user)
            ->get(route('location.edit', $this->location->id))
            ->assertStatus(501);
    }

    public function testUpdate()
    {
        // create mock customer
        $target = Location::factory()->create();
        $update = Location::factory()->make()->getAttributes();

        // unauth redirect to login
        $this->json('PUT', route('location.update', $target->id), $update)
            ->assertStatus(401);

        // authed
        $this->actingAs($this->user)
            ->json('PUT', route('location.update', $target->id), $update)
            ->assertStatus(501);
    }

    public function testDestroy()
    {
        $toDel = Location::factory()->create();

        // unauth redirect to login
        $this->delete(route('location.destroy', $toDel->id))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // authed
        $this->actingAs($this->user)
            ->delete(route('location.destroy', $toDel->id))
            ->assertStatus(302)
            ->assertRedirect(route('customer.show', $toDel->customer->id));
        $this->assertDatabaseMissing('locations', $toDel->getAttributes());
    }
}
