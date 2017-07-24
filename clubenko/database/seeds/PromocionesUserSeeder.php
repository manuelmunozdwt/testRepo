<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;

class PromocionesUserSeeder extends Seeder
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
                    foreach($tienda->promocion as $promocion){
                        $promociones_user[] =
                        [
                            'user_id' => $comercio->id,
                            'promocion_id'=> $promocion->id
                       ];
                    }
                }
            }
        }
        DB::table('promociones_user')->insert($promociones_user);

    }
}
