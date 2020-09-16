<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhoneTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('phone_types')->insert([
            'type' => 'Cell',
        ]);

        DB::table('phone_types')->insert([
            'type' => 'Home',
        ]);

        DB::table('phone_types')->insert([
            'type' => 'Work',
        ]);
    }
}
