<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@localhost.com',
            'password' => '$2y$10$tMAGdHz8M1EpyRKfAQFt5.Xofg9LnJuWMrUnj8O2CHrfP5oVxwlHK',
            'remember_token' => NULL,
            'created_at' => '2016-08-21 21:49:48',
            'updated_at' => '2016-08-21 21:49:48'
        ]);
    }
}
