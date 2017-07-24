<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Tienda;
use App\Models\Cupon;

class CuponesTiendasTableSeeder extends Seeder
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

        $cupones = Cupon::all();

        foreach ($cupones as $cupon) {

            $tienda = $tiendas[array_rand($tiendas, 1)];
            $tiendas_cupon[] =
            [
                'id_tienda' => $tienda,
                'id_cupon' => $cupon->id,
            ];
             
        }

        DB::table('cupones_tiendas')->insert($tiendas_cupon);
    }
}
