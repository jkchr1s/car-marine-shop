<?php

namespace Database\Factories;

use App\Customer;
use App\Phone;
use App\PhoneType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PhoneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Phone::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id' => Customer::factory()->create()->id,
            'phone_type_id' => PhoneType::factory()->create()->id,
            'number' => $this->faker->phoneNumber(),
        ];
    }
}
