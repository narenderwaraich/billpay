<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('users')->insert([
            'fname' => 'Online',
            'lname' => 'Bill',
            'email' => 'admin@admin.com',
            'password' => bcrypt('Singh@786'),
            'avatar' => 'ADMIN_LOGO.jpg',
            'phone_no' => '9017109900',
            'company_name' => 'ourWork',
            'address' => 'Phase 9',
            'country' => 'India',
            'state' => 'Punjab',
            'city' => 'Mohali',
            'zipcode' => '160062',
            'role' =>'admin',
            'is_activated' => 1,
        ]);
    }
}
