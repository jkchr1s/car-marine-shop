<?php

namespace Database\Factories;

use App\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // randomly recide if this is a company
        $company = rand(0, 1) === 1;

        return [
            'customer_type_id' => $company ? 2 : 1,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'company' => $company ? $this->faker->company : null,
        ];
    }
}
