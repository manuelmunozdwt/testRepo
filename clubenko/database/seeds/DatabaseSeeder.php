<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolessTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TiendasTableSeeder::class);
        $this->call(UsuariosTiendasTableSeeder::class);
        $this->call(CategoriasTableSeeder::class);
        $this->call(PermisosTableSeeder::class);
        $this->call(PermisosRolesTableSeeder::class);
        $this->call(PermisosUserTableSeeder::class);
        $this->call(SubcategoriasTableSeeder::class);
        $this->call(FiltrosTableSeeder::class);
        $this->call(CuponesTableSeeder::class);
        $this->call(CuponesTiendasTableSeeder::class);
        $this->call(CuponesUserSeeder::class);
        $this->call(ComentariosSeeder::class);
        $this->call(PromocionesTableSeeder::class);
        $this->call(PromocionesTiendasTableSeeder::class);
        $this->call(PromocionesUserSeeder::class);
        $this->call(BloquesTableSeeder::class);
        $this->call(ProvinciasTableSeeder::class);
    }
}
