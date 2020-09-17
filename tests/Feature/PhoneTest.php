<?php

namespace Tests\Feature;

use App\Phone;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhoneTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // seed customer types
        $this->seed('CustomerTypeTableSeeder');

        // create mock user
        $this->user = User::factory()->create();

        // create mock email
        $this->phone = Phone::factory()->create();

        // get reference to mock customer
        $this->customer = $this->phone->customer;

        // get reference to mock phone type
        $this->phoneType = $this->phone->phone_type;

        $this->faker = Factory::create();
    }

    public function testIndex()
    {
        // check unauthenticated
        $this->get(route('phone.index'))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // check authenticated
        $this->actingAs($this->user)
            ->get(route('phone.index'))
            ->assertStatus(501);
    }

    public function testCreate()
    {
        // check unauthenticated
        $this->get(route('phone.create'))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // check authenticated
        $this->actingAs($this->user)
            ->get(route('phone.create'))
            ->assertStatus(501);
    }

    public function testStore()
    {
        // create mock phone
        $phone = [
            'customer_id' => $this->customer->id,
            'phone_type_id' => $this->phoneType->id,
            'number' => $this->faker->phoneNumber(),
        ];

        // unauthed
        $response = $this->json('POST', route('phone.store'), $phone)
            ->assertStatus(401);
        $this->assertDatabaseMissing('phones', $phone);

        // authed
        $response = $this->actingAs($this->user)
            ->json('POST', route('phone.store'), $phone)
            ->assertStatus(302);
        $this->assertDatabaseHas('phones', $phone);
    }

    public function testShow()
    {
        // check unauthenticated
        $this->get(route('phone.show', $this->phone->id))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // check authenticated
        $this->actingAs($this->user)
            ->get(route('phone.show', $this->phone->id))
            ->assertStatus(501);
    }

    public function testEdit()
    {
        // check unauthenticated
        $this->get(route('phone.edit', $this->phone->id))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // check authenticated
        $this->actingAs($this->user)
            ->get(route('phone.edit', $this->phone->id))
            ->assertStatus(501);
    }

    public function testUpdate()
    {
        // create mock object
        $target = Phone::factory()->create();
        $update = [
            'number' => $this->faker->phoneNumber(),
        ];

        // unauth redirect to login
        $this->json('PUT', route('phone.update', $target->id), $update)
            ->assertStatus(401);

        // authed
        $this->actingAs($this->user)
            ->json('PUT', route('phone.update', $target->id), $update)
            ->assertStatus(501);
    }

    public function testDestroy()
    {
        $toDel = Phone::factory()->create();

        // unauth redirect to login
        $this->delete(route('phone.destroy', $toDel->id))
            ->assertStatus(302)
            ->assertRedirect('/login');
        $this->assertDatabaseHas('phones', $toDel->getAttributes());

        // authed
        $this->actingAs($this->user)
            ->delete(route('phone.destroy', $toDel->id))
            ->assertStatus(302)
            ->assertRedirect(route('customer.show', $toDel->customer->id));
        $this->assertDatabaseMissing('phones', $toDel->getAttributes());
    }
}
