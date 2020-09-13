<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocationTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('location_types')->insert([
            'type' => 'Billing Address'
        ]);

        DB::table('location_types')->insert([
            'type' => 'Mailing Address'
        ]);

        DB::table('location_types')->insert([
            'type' => 'Vehicle Location'
        ]);
    }
}
