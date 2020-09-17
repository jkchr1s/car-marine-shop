<?php

namespace Tests\Feature;

use App\Customer;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // seed customer types
        $this->seed('CustomerTypeTableSeeder');

        // create mock user
        $this->user = User::factory()->create();

        // create mock customer
        $this->customer = Customer::factory()->create();

        $this->faker = Factory::create();
    }

    public function testIndex()
    {
        // check unauthenticated
        $this->get(route('customer.index'))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // check authenticated
        $response = $this->actingAs($this->user)
            ->get(route('customer.index'));

        // make sure we got a 200
        $response->assertStatus(200);

        // make sure we see the customer's name
        $response->assertSee($this->customer->first_name)
            ->assertSee($this->customer->last_name);

        // make sure there's a link to see the customer details
        $response->assertSee(route('customer.show', $this->customer->id));
    }

    public function testCreate()
    {
        // unauth redirect to login
        $this->get(route('customer.create'))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // authed should get too
        $this->actingAs($this->user)
            ->get(route('customer.create'))
            ->assertStatus(200);
    }

    public function testStore()
    {
        // create mock customer
        $customer = Customer::factory()->make()->getAttributes();

        // unauthed
        $response = $this->json('POST', route('customer.store'), $customer)
            ->assertStatus(401);
        $this->assertDatabaseMissing('customers', $customer);

        // authed
        $response = $this->actingAs($this->user)
            ->json('POST', route('customer.store'), $customer)
            ->assertStatus(302);
        $this->assertDatabaseHas('customers', $customer);
    }

    public function testShow()
    {
        // unauth redirect to login
        $this->get(route('customer.show', $this->customer->id))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // authed
        $response = $this->actingAs($this->user)
            ->get(route('customer.show', $this->customer->id))
            ->assertStatus(200);

        // check output
        if ($this->customer->customer_type_id === 1) {
            $response->assertSee($this->customer->first_name)
                ->assertSee($this->customer->last_name);
        } else {
            $response->assertSee($this->customer->company);
        }
    }

    public function testEdit()
    {
        // unauth redirect to login
        $this->get(route('customer.edit', $this->customer->id))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // authed
        $this->actingAs($this->user)
            ->get(route('customer.edit', $this->customer->id))
            ->assertStatus(501);
    }

    public function testUpdate()
    {
        // create mock customer
        $target = Customer::factory()->create();
        $update = Customer::factory()->make()->getAttributes();

        // unauth redirect to login
        $this->json('PUT', route('customer.update', $target->id), $update)
            ->assertStatus(401);

        // authed
        $this->actingAs($this->user)
            ->json('PUT', route('customer.update', $target->id), $update)
            ->assertStatus(501);
    }

    public function testDestroy()
    {
        $toDel = Customer::factory()->create();

        // unauth redirect to login
        $this->delete(route('customer.destroy', $toDel->id))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // authed
        $this->actingAs($this->user)
            ->delete(route('customer.destroy', $toDel->id))
            ->assertStatus(302)
            ->assertRedirect(route('customer.index'));
        $this->assertDatabaseMissing('customers', $toDel->getAttributes());
    }
}
