<?php

namespace Database\Factories;

use App\VehicleMake;
use App\VehicleModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VehicleModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VehicleModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $make = VehicleMake::factory()->create();

        return [
            'vehicle_type_id' => $make->vehicle_type_id,
            'vehicle_make_id' => $make->id,
            'model' => $this->faker->catchPhrase(),
        ];
    }
}
