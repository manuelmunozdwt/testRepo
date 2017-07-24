<?php

use Illuminate\Database\Seeder;

class FiltrosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('filtros')->insert([

            ['nombre' => '2x1'],
            ['nombre' => '5%'],
            ['nombre' => '10%'],
        	['nombre' => '15%'],
            ['nombre' => '20%'],
        	['nombre' => '25%'],
            ['nombre' => '30%'],
        	['nombre' => '35%'],
            ['nombre' => '40%'],
            ['nombre' => '45%'],
            ['nombre' => '50%'],
            ['nombre' => '55%'],
            ['nombre' => '60%'],
            ['nombre' => '65%'],
            ['nombre' => '70%'],
            ['nombre' => '75%'],
            ['nombre' => '80%'],
            ['nombre' => '85%'],
            ['nombre' => '90%'],
            ['nombre' => '95%'],
        	['nombre' => '100%'],
        ]);    
    }
}
