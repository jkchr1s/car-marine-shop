<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CustomerTypeTableSeeder::class);
        $this->call(LocationTypeTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(VehicleTypeSeeder::class);
        $this->call(VehicleMakeSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PhoneTypesSeeder::class);
    }
}
