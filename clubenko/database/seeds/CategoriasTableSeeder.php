<?php

use Illuminate\Database\Seeder;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias')->insert([
        	[
        	 'nombre' => 'Moda',
        	 'slug' => 'moda-y-complementos',
        	 'imagen' => 'img/shopping.png',
             'estandar' => '1', 
             'confirmado'  => '1'
        	 ],

        	[
        	 'nombre' => 'Ocio y Cultura',
        	 'slug' => 'ocio',
        	 'imagen' => 'img/teatro.png',
             'estandar' => '1', 
             'confirmado'  => '1'
        	 ],

            [
             'nombre' => 'Restaurantes',
             'slug' => 'restaurantes',
             'imagen' => 'img/gastronomia.png',
             'estandar' => '1', 
             'confirmado'  => '1'
             ],

        	[
        	 'nombre' => 'Viajes',
        	 'slug' => 'viajes',
        	 'imagen' => 'img/viajes.png',
             'estandar' => '1', 
             'confirmado'  => '1'
        	 ],

             [
             'nombre' => 'Hoteles',
             'slug' => 'hoteles',
             'imagen' => 'img/hotel.png',
             'estandar' => '1', 
             'confirmado'  => '1'
             ],
             
            [
             'nombre' => 'Salud y Belleza',
             'slug' => 'salud-y-belleza',
             'imagen' => 'img/salud-belleza.png',
             'estandar' => '1', 
             'confirmado'  => '1'
             ],

            [
             'nombre' => 'Electrónica',
             'slug' => 'electronica',
             'imagen' => 'img/electronica.png',
             'estandar' => '1', 
             'confirmado'  => '1'
             ],

            [
             'nombre' => 'Regalos',
             'slug' => 'regalos',
             'imagen' => 'img/regalos.png',
             'estandar' => '1', 
             'confirmado'  => '1'
             ],

            [
             'nombre' => 'Alimentación',
             'slug' => 'alimentacion',
             'imagen' => 'img/supermercado-alimentacion.png',
             'estandar' => '1', 
             'confirmado'  => '1'
             ],

            [
             'nombre' => 'Hogar y Decoración',
             'slug' => 'hogar-y-decoracion',
             'imagen' => 'img/decoracion-hogar.png',
             'estandar' => '1', 
             'confirmado'  => '1'
             ],

            [
             'nombre' => 'Deporte y Aventura',
             'slug' => 'deporte-y-aventura',
             'imagen' => 'img/deportes.png',
             'estandar' => '1', 
             'confirmado'  => '1'
             ],

            [
             'nombre' => 'Motor',
             'slug' => 'motor',
             'imagen' => 'img/motor.png',
             'estandar' => '1', 
             'confirmado'  => '1'
             ],

            [
             'nombre' => 'Formación',
             'slug' => 'formacion',
             'imagen' => 'img/formacion.png',
             'estandar' => '1', 
             'confirmado'  => '1'
             ],

            [
             'nombre' => 'Servicios Profesionales',
             'slug' => 'servicios-profesionales',
             'imagen' => 'img/servicios-profesionales.png',
             'estandar' => '1', 
             'confirmado'  => '1'
             ],

            [
             'nombre' => 'Mascotas',
             'slug' => 'mascotas',
             'imagen' => 'img/mascotas.png',
             'estandar' => '1', 
             'confirmado'  => '1'
             ]

        ]);    
    }
}
