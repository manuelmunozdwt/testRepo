<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Tienda;

class UsuariosTiendasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios_tiendas')->insert([
        	['id_usuario' => '4', 'id_tienda' => '1'],
        	['id_usuario' => '4', 'id_tienda' => '2'],
        	['id_usuario' => '4', 'id_tienda' => '3']
        ]);
        
        $users = User::where('confirmado', 1)->where('rol', 2)->lists('id')->toArray();

        $tiendas = Tienda::where('confirmado', 1)->lists('id')->toArray();

        foreach ($tiendas as $tienda) {
            $user = $users[array_rand($users, 1)];
            DB::table('usuarios_tiendas')->insert([
                'id_tienda' => $tienda,
                'id_usuario' => $user
            ]);
        }        
    }
}
