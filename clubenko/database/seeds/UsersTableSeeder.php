<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
             
            ['name' => 'Antonio',
             'email' => 'antonio@lopez.com',
             'dni' => '11111111',
             'slug' => 'antonio',
             'password' => bcrypt('123123'),
             'confirmado' => '1',
             'rol' => '1'],

            ['name' => 'Sergio Ramos',
             'email' => 'sergio.ramos@consultaclick.es',
             'dni' => '22222222',
             'slug' => 'sergio-ramos',
             'password' => bcrypt('123123'),
             'confirmado' => '1',
             'rol' => '1'],

            ['name' => 'Pablo Ramos',
             'email' => 'pablo.ramos@enkoteams.com',
             'dni' => '33333333',
             'slug' => 'pablo-ramos',
             'password' => bcrypt('123123'),
             'confirmado' => '1',
             'rol' => '1']

        ]);
        //Creamos 50 usuarios
        $faker = Faker::create('es_ES');
        foreach (range(1,50) as $index) {
            $user[] = 
            [
                'name' => $faker->name,
                'email' => $faker->email,
                'dni' =>  $faker->unique()->dni,
                'slug' => normalizar_string($faker->name),
                'password' => bcrypt('123123'),
                'confirmado' => '1',
                'rol' => '1'
            ];
        }
        DB::table('users')->insert($user);

        DB::table('users')->insert([
             'name' => 'Comercio',
             'email' => 'comercio@comercio.com',
             'dni' => 'comercio',
             'slug' => 'comercio',
             'password' => bcrypt('123123'),
             'confirmado' => '1',
             'rol' => '2'
            ]);

        DB::table('users')->insert([
             'name' => 'Comercio',
             'email' => 'administrador@administrador.com',
             'dni' => 'administrador',
             'slug' => 'comercio',
             'password' => bcrypt('123123'),
             'confirmado' => '1',
             'rol' => '3'
        ]);
        
        //Creamos 20 comercios
        $faker = Faker::create('es_ES');
        foreach (range(1,20) as $index) {
            $comercios[] = 
            [
                'name' => $faker->company,
                'email' => $faker->email,
                'dni' => $faker->unique()->dni,
                'slug' => normalizar_string($faker->name),
                'password' => bcrypt('123123'),
                'confirmado' => '1',
                'rol' => '2'
            ];
        }
        DB::table('users')->insert($comercios);

    }
}
