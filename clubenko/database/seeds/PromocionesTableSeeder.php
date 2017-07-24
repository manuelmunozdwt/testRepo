<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Subcategoria;

class PromocionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $subcategorias_all = Subcategoria::get()->toArray();

        //Creamos 100 promociones 
        $faker = Faker::create('es_ES');
        foreach (range(303,2030) as $index) {
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

            $promociones[] = 
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
                 'precio'       => $faker->numberBetween($min = 100, $max = 200),
                 'precio_descuento' => $faker->numberBetween($min = 10, $max = 100),
                 'filtro_id' => $faker->numberBetween($min = 1, $max = 21)
            ];
        }

        DB::table('promociones')->insert($promociones);

    }
}
