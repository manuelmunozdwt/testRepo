<?php

use Illuminate\Database\Seeder;

class BloquesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bloques_inicio')->insert([
            [
                'tipo' => 'populares',
                'cupon_id' => 1,
                'cupon_id2' => null,
                'enlace' => null,
                'imagen' => null,
            ],

            [
                'tipo' => 'populares',
                'cupon_id' => 2,
                'cupon_id2' => null,
                'enlace' => null,
                'imagen' => null,
            ],

            [
                'tipo' => 'populares',
                'cupon_id' => 3,
                'cupon_id2' => null,
                'enlace' => null,
                'imagen' => null,
            ],

            [ 
            
                'tipo' => 'slide',
                'cupon_id' => 1,
                'cupon_id2' => null,
                'enlace' => null,
                'imagen' => null,
            ],

            [
                'tipo' => 'slide',
                'cupon_id' => 2,
                'cupon_id2' => null,
                'enlace' => null,
                'imagen' => null,
            ],

            [
                'tipo' => 'slide',
                'cupon_id' => 3,
                'cupon_id2' => null,
                'enlace' => null,
                'imagen' => null,
            ],
            

            [
                'tipo' => 'bloque',
                'cupon_id' => 1,
                'cupon_id2' => 2,
                'enlace' => 'motor',
                'imagen' => 'img/taller.png',
            ],

            [
                'tipo' => 'bloque',
                'cupon_id' => 3,
                'cupon_id2' => 1,
                'enlace' => 'ocio',
                'imagen' => 'img/spa.png',
            ],

            [
                'tipo' => 'bloque',
                'cupon_id' => 2,
                'cupon_id2' => 3,
                'enlace' => 'restaurantes',
                'imagen' => 'img/pizza.png',
            ],



       	]);
    }
}
