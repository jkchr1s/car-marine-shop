<?php

namespace Database\Seeders;

use App\VehicleType;
use Illuminate\Database\Seeder;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $record = new VehicleType();
        $record->id = 1;
        $record->type = 'Boat/PWC';
        $record->icon = 'directions_boat';
        $record->save();

        $record = new VehicleType();
        $record->id = 2;
        $record->type = 'Car/Truck/SUV';
        $record->icon = 'directions_car';
        $record->save();

        $record = new VehicleType();
        $record->id = 3;
        $record->type = 'Motorcycle/ATV/SxS';
        $record->icon = 'motorcycle';
        $record->save();

        $record = new VehicleType();
        $record->id = 4;
        $record->type = 'Recreational Vehicles';
        $record->icon = 'directions_bus';
        $record->save();
    }
}
