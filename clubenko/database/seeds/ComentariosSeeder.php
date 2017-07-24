<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ComentariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comentarios')->insert([
        	[
        	'comentario' => 'Genial! Muy recomendable.',
        	'user_id' => '1',
        	'cupon_id' => '1',
        	'confirmado' => '1'
        	],

        	[
        	'comentario' => 'La atención fantástica, y todo muy bueno.',
        	'user_id' => '1',
        	'cupon_id' => '2',
        	'confirmado' => '1'
        	],

        	[
        	'comentario' => 'Nos encanta venir aquí, siempre nos tratan de lujo.',
        	'user_id' => '1',
        	'cupon_id' => '3',
        	'confirmado' => '1'
        	],


        ]);
        $faker = Faker::create('es_ES');

        foreach (range(1, 500) as $index){
            $comentarios[] =
            [
                'comentario' =>  $faker->text($maxNbChars = 200, $indexSize = 2),
                'user_id' => $faker->numberBetween($min = 1, $max = 50),
                'cupon_id' => $faker->numberBetween($min = 1, $max = 303),
                'confirmado' => $faker->biasedNumberBetween($min = 0, $max =1 , $function = 'sqrt'),
            ];
        }

        DB::table('comentarios')->insert($comentarios);
    }
}
