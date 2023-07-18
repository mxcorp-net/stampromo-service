<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'Alfonso',
            'last_name'=> 'Rodriguez',
            'email' => 'alfonso@mxcorp.com',
            'password' => Hash::make('123456789')
        ]);

        DB::table('users')->insert([
            'first_name' => 'Pedro',
            'last_name'=> 'Luna',
            'email' => 'pedro@mxcorp.com',
            'password' => Hash::make('123456789')
        ]);

        DB::table('users')->insert([
            'first_name' => 'Rocio',
            'last_name'=> 'Romero',
            'email' => 'rocio@mxcorp.com',
            'password' => Hash::make('123456789')
        ]);
    }
}
