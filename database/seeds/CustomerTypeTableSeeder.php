<?php

use Illuminate\Database\Seeder;

class CustomerTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customer_types')->insert([
            'type' => 'Personal',
            'icon' => 'person'
        ]);

        DB::table('customer_types')->insert([
            'type' => 'Business',
            'icon' => 'business'
        ]);
    }
}
