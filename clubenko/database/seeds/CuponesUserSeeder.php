<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;

class CuponesUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create('es_ES');
        $comercios = User::where('confirmado', 1)->where('rol', 2)->with('tienda')->get();

        foreach($comercios as $comercio){
            $tiendas = $comercio->tienda;
            if(!empty($tiendas->toArray())){
                foreach($tiendas as $tienda){
                    foreach($tienda->cupon as $cupon){
                        $cupones_user[] =
                        [
                            'user_id' => $comercio->id,
                            'cupon_id'=> $cupon->id
                       ];
                    }
                }
            }
        }
        DB::table('cupones_user')->insert($cupones_user);
    }
}
