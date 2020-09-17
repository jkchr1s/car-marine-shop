<?php

namespace Database\Factories;

use App\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VehicleTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VehicleType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->catchPhrase(),
            'icon' => collect(['directions_boat', 'directions_car', 'motorcycle', 'directions_bus'])->random(),
        ];
    }
}
