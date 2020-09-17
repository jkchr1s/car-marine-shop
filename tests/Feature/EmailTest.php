<?php

namespace Tests\Feature;

use App\Email;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailTest extends TestCase
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
        $this->email = Email::factory()->create();

        // get reference to mock customer
        $this->customer = $this->email->customer;

        $this->faker = Factory::create();
    }

    public function testIndex()
    {
        // check unauthenticated
        $this->get(route('email.index'))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // check authenticated
        $this->actingAs($this->user)
            ->get(route('email.index'))
            ->assertStatus(501);
    }

    public function testCreate()
    {
        // check unauthenticated
        $this->get(route('email.create'))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // check authenticated
        $this->actingAs($this->user)
            ->get(route('email.create'))
            ->assertStatus(501);
    }

    public function testStore()
    {
        // create mock email
        $email = [
            'customer_id' => $this->customer->id,
            'email' => $this->faker->safeEmail(),
        ];

        // unauthed
        $response = $this->json('POST', route('email.store'), $email)
            ->assertStatus(401);
        $this->assertDatabaseMissing('emails', $email);

        // authed
        $response = $this->actingAs($this->user)
            ->json('POST', route('email.store'), $email)
            ->assertStatus(302);
        $this->assertDatabaseHas('emails', $email);
    }

    public function testShow()
    {
        // check unauthenticated
        $this->get(route('email.show', $this->email->id))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // check authenticated
        $this->actingAs($this->user)
            ->get(route('email.show', $this->email->id))
            ->assertStatus(501);
    }

    public function testEdit()
    {
        // check unauthenticated
        $this->get(route('email.edit', $this->email->id))
            ->assertStatus(302)
            ->assertRedirect('/login');

        // check authenticated
        $this->actingAs($this->user)
            ->get(route('email.edit', $this->email->id))
            ->assertStatus(501);
    }

    public function testUpdate()
    {
        // create mock object
        $target = Email::factory()->create();
        $update = [
            'email' => $this->faker->safeEmail(),
        ];

        // unauth redirect to login
        $this->json('PUT', route('email.update', $target->id), $update)
            ->assertStatus(401);

        // authed
        $this->actingAs($this->user)
            ->json('PUT', route('email.update', $target->id), $update)
            ->assertStatus(501);
    }

    public function testDestroy()
    {
        $toDel = Email::factory()->create();

        // unauth redirect to login
        $this->delete(route('email.destroy', $toDel->id))
            ->assertStatus(302)
            ->assertRedirect('/login');
        $this->assertDatabaseHas('emails', $toDel->getAttributes());

        // authed
        $this->actingAs($this->user)
            ->delete(route('email.destroy', $toDel->id))
            ->assertStatus(302)
            ->assertRedirect(route('customer.show', $toDel->customer->id));
        $this->assertDatabaseMissing('emails', $toDel->getAttributes());
    }
}
