<?php

namespace Database\Factories;

use App\VehicleMake;
use App\VehicleType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VehicleMakeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VehicleMake::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vehicle_type_id' => VehicleType::factory()->create()->id,
            'make' => $this->faker->company(),
            'icon' => collect(['directions_boat', 'directions_car', 'motorcycle', 'directions_bus'])->random(),
        ];
    }
}
