<?php

namespace Database\Seeders;

use App\VehicleMake;
use App\VehicleModel;
use Illuminate\Database\Seeder;

class VehicleModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $makes = VehicleMake::select('id', 'vehicle_type_id')
            ->get()
            ->each(function (VehicleMake $make) {
                VehicleModel::create([
                    'vehicle_type_id' => $make->vehicle_type_id,
                    'vehicle_make_id' => $make->id,
                    'model' => sprintf('Example %s %s', $make->vehicle_type->type, $make->make),
                ]);
            });
    }
}
