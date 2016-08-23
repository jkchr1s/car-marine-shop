<?php

use Illuminate\Database\Seeder;

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
            'type' => 'Cell'
        ]);

        DB::table('phone_types')->insert([
            'type' => 'Home'
        ]);

        DB::table('phone_types')->insert([
            'type' => 'Work'
        ]);
    }
}
