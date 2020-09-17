<?php

namespace Database\Factories;

use App\Customer;
use App\Vehicle;
use App\VehicleModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $model = VehicleModel::factory()->create();

        return [
            'customer_id' => Customer::factory()->create()->id,
            'vehicle_type_id' => $model->vehicle_type_id,
            'vehicle_make_id' => $model->vehicle_make_id,
            'vehicle_model_id' => $model->id,
            'year' => Carbon::now()->format('Y'),
        ];
    }
}
