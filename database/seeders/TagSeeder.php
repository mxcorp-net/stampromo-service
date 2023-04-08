<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert(['word' => 'Plastico']);
        DB::table('tags')->insert(['word' => 'Metal']);
        DB::table('tags')->insert(['word' => 'Madera']);
        DB::table('tags')->insert(['word' => 'Vidrio']);
    }
}
