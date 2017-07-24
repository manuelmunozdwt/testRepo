<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Subcategoria;

class CuponesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cupones')->insert([
        	['titulo' => 'Spa para dos',
        	 'descripcion' => 'Disfruta en nuestro spa de un día de relax con quien tú elijas',
        	 'imagen' => 'spa.png',
        	 'slug' => 'spa-para-dos',
        	 'fecha_inicio' => '2016-06-04 00:00:00',
        	 'fecha_fin' => '2016-12-31 00:00:00',
        	 'confirmado' => 1,
        	 'categoria_id' => 2,
        	 'subcategoria_id' => null,
        	 'filtro_id' => 1
        	],

        	['titulo' => 'Descuento en pizzas familiares',
        	 'descripcion' => 'Ahorra más con tus pizzas familiares favoritas',
        	 'imagen' => 'pizza.png',
        	 'slug' => 'descuento-en-pizzas-familiares',
        	 'fecha_inicio' => '2016-06-04 00:00:00',
        	 'fecha_fin' => '2016-12-31 00:00:00',
        	 'confirmado' => 1,
        	 'categoria_id' => 3,
        	 'subcategoria_id' => 13,
        	 'filtro_id' => 3
        	],

        	['titulo' => 'Pon tu coche a punto',
             'descripcion' => 'Consigue un descuento del 10% en las revisión pre-ITV',
             'imagen' => 'taller.png',
             'slug' => 'pon-tu-coche-a-punto',
             'fecha_inicio' => '2016-06-04 00:00:00',
             'fecha_fin' => '2016-12-31 00:00:00',
             'confirmado' => 1,
             'categoria_id' => 5,
             'subcategoria_id' => null,
             'filtro_id' => 2
            ],


        ]);

        $subcategorias_all = Subcategoria::get()->toArray();

        //Creamos 100 cupones 
        $faker = Faker::create('es_ES');

        foreach (range(1,3030) as $index) {

            $this->categoria = $faker->numberBetween($min = 1, $max = 15);
            
            $subcategorias = array_where($subcategorias_all, function ($key, $value) {

                 if($value['categoria_id'] == $this->categoria){

                    return $value;

                 }
            });

            if(empty($subcategorias)){

              $subcategoria =  null;

            }else{

              $subcategoria = $subcategorias[array_rand($subcategorias, 1)];

            }

            $cupones[] = 
            [
                 'titulo' => $faker->sentence($nbWords = 5, $variableNbWords = true) ,
                 'descripcion' => $faker->text($maxNbChars = 500),
                 'descripcion_corta' => $faker->text($maxNbChars = 100),
                 'condiciones' => $faker->text($maxNbChars = 500),
                 'imagen' => 'spa.png',
                 'slug' => normalizar_string($faker->sentence($nbWords = 5, $variableNbWords = true)),
                 'fecha_inicio' => $faker->dateTimeInInterval($startDate = '-1 month', $interval = '-1 week', $timezone = date_default_timezone_get()) ,
                 'fecha_fin' => $faker->dateTimeInInterval($startDate = '-1 month', $interval = '+ 2 month', $timezone = date_default_timezone_get()) ,
                 'confirmado' => $faker->biasedNumberBetween($min = 0, $max =1 , $function = 'sqrt'),
                 'categoria_id' => $this->categoria,
                 'subcategoria_id' => $subcategoria['categoria_id'],
                 'filtro_id' => $faker->numberBetween($min = 1, $max = 21)
            ];
        }

        DB::table('cupones')->insert($cupones);
    }
}
