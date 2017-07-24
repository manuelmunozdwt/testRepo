<?php

use Illuminate\Database\Seeder;

class RolessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
        	['nombre' => 'Usuario'],
        	['nombre' => 'Comercio'],
        	['nombre' => 'Administrador']
        ]);
    }
}
