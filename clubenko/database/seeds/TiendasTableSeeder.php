<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TiendasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tiendas')->insert([
        	['nombre' => 'Tienda 1', 
            'slug' => 'tienda-1',
            'direccion' => 'calle Faraday 7, Madrid',
            'latitud' => '40.5488552',
            'longitud' => '-3.6912135',
            'telefono' => '654654654',
            'web' => 'www.example.com',
            'confirmado' => 1,
            'provincia_id' => 2
            ],
        	['nombre' => 'Tienda 2', 
            'slug' => 'tienda-2',
            'direccion' => 'calle Faraday 7, Madrid',
            'latitud' => '40.5488552',
            'longitud' => '-3.6912135',
            'telefono' => '654654654',
            'web' => 'www.example.com',
            'confirmado' => 1,
            'provincia_id' => 3
            ],
        	['nombre' => 'Tienda 3', 
            'slug' => 'tienda-3',
            'direccion' => 'calle Faraday 7, Madrid',
            'latitud' => '40.5488552',
            'longitud' => '-3.6912135',
            'telefono' => '654654654',
            'web' => 'www.example.com',
            'confirmado' => 1,
            'provincia_id' => 1
            ]
        ]);

        //crear 1000 tiendas confirmadas
        $faker = Faker::create('es_ES');
        foreach (range(1,1000) as $index) {
            $tiendas[] = [
                'nombre' => $faker->sentence($nbWords = 2, $variableNbWords = true) ,
                'direccion' => $faker->address,
                'slug' => normalizar_string($faker->unique()->sentence($nbWords = 2, $variableNbWords = true)),
                'latitud' => $faker->latitude($min = 36, $max = 43) ,
                'longitud' => $faker->longitude($min = -6, $max = 3) ,
                'telefono' => $faker->phoneNumber,
                'web' => $faker->domainName,
                'confirmado' => 1,
                'provincia_id' => $faker->numberBetween($min = 1, $max = 52)
            ];
        }
        DB::table('tiendas')->insert($tiendas);

        //crear 20 tiendas sin confirmar
        $faker = Faker::create('es_ES');
        foreach (range(1,20) as $index) {
            $tiendas_sin_confirmar[] = [
                'nombre' => $faker->sentence($nbWords = 2, $variableNbWords = true) ,
                'direccion' => $faker->address,
                'slug' => normalizar_string($faker->unique()->sentence($nbWords = 2, $variableNbWords = true)),
                'latitud' => $faker->latitude($min = 36, $max = 43) ,
                'longitud' => $faker->longitude($min = -6, $max = 3) ,
                'telefono' => $faker->phoneNumber,
                'web' => $faker->domainName,
                'confirmado' => 0,
                'provincia_id' => $faker->numberBetween($min = 1, $max = 52)
            ];
        }
        DB::table('tiendas')->insert($tiendas_sin_confirmar);

    }
}
