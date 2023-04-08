<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->insert([
            'name' => 'Amarillo',
            'hex'=> 'ffff00 '
        ]);

        DB::table('colors')->insert([
            'name' => 'Azul',
            'hex'=> '0000ff'
        ]);

        DB::table('colors')->insert([
            'name' => 'Rojo',
            'hex'=> 'ff0000'
        ]);
    }
}
