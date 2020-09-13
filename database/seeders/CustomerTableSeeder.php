<?php

namespace Database\Seeders;

use App\Customer;
use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = new Customer();
        $customer->first_name = 'Chris';
        $customer->last_name = 'Bethel';
        $customer->customer_type_id = 1;
        $customer->company = '';
        $customer->save();
    }
}
