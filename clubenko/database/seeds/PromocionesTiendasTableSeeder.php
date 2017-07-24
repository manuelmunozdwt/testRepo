<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Tienda;
use App\Models\Promocion;

class PromocionesTiendasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
                //crear 1000 tiendas confirmadas
        $faker = Faker::create('es_ES');

        $tiendas = Tienda::where('confirmado', 1)->lists('id')->toArray();

        $promociones = Promocion::all();

        foreach ($promociones as $promocion) {

            $tienda = $tiendas[array_rand($tiendas, 1)];
            $tiendas_cupon[] =
            [
                'id_tienda' => $tienda,
                'id_promocion' => $promocion->id,
            ];
             
        }

        DB::table('promociones_tiendas')->insert($tiendas_cupon);
    }
}
