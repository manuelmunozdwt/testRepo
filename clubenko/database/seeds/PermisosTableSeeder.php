<?php

use Illuminate\Database\Seeder;

class PermisosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permisos')->insert([
            [
            'nombre' => 'Ver lista usuarios',
            'slug' => 'ver-lista-usuarios'
            ],

            [
            'nombre' => 'Ver detalle usuarios',
            'slug' => 'ver-detalle-usuarios'
            ],

            [
            'nombre' => 'Crear usuarios',
            'slug' => 'crear-usuarios'
            ],

            [
            'nombre' => 'Editar usuarios',
            'slug' => 'editar-usuarios'
            ],

            [
            'nombre' => 'Validar usuarios',
            'slug' => 'validar-usuarios'
            ],

            [
            'nombre' => 'Borrar usuarios',
            'slug' => 'borrar-usuarios'
            ],

            [
            'nombre' => 'Ver mis tiendas',
            'slug' => 'ver-lista-tiendas'
            ],

            [
            'nombre' => 'Gestionar tiendas',
            'slug' => 'gestionar-tiendas'
            ],

            [
            'nombre' => 'Crear tiendas',
            'slug' => 'crear-tiendas'
            ],

            [
            'nombre' => 'Editar tiendas',
            'slug' => 'editar-tiendas'
            ],

            [
            'nombre' => 'Validar tiendas',
            'slug' => 'validar-tiendas'
            ],

            [
            'nombre' => 'Borrar tiendas',
            'slug' => 'borrar-tiendas'
            ],

            [
            'nombre' => 'Ver lista cupones',
            'slug' => 'ver-lista-cupones'
            ],

            [
            'nombre' => 'Ver detalle cupones',
            'slug' => 'ver-detalle-cupones'
            ],

            [
            'nombre' => 'Crear cupones',
            'slug' => 'crear-cupones'
            ],

            [
            'nombre' => 'Editar cupones',
            'slug' => 'editar-cupones'
            ],

            [
            'nombre' => 'Validar cupones',
            'slug' => 'validar-cupones'
            ],

            [
            'nombre' => 'Borrar cupones',
            'slug' => 'borrar-cupones'
            ],

            [
            'nombre' => 'Ver lista roles',
            'slug' => 'ver-lista-roles'
            ],

            [
            'nombre' => 'Ver detalle roles',
            'slug' => 'ver-detalle-roles'
            ],

            [
            'nombre' => 'Crear roles',
            'slug' => 'crear-roles'
            ],

            [
            'nombre' => 'Editar roles',
            'slug' => 'editar-roles'
            ],

            [
            'nombre' => 'Validar roles',
            'slug' => 'validar-roles'
            ],

            [
            'nombre' => 'Borrar roles',
            'slug' => 'borrar-roles'
            ],

            [
            'nombre' => 'Ver lista permisos',
            'slug' => 'ver-lista-permisos'
            ],

            [
            'nombre' => 'Ver detalle permisos',
            'slug' => 'ver-detalle-permisos'
            ],

            [
            'nombre' => 'Crear permisos',
            'slug' => 'crear-permisos'
            ],

            [
            'nombre' => 'Editar permisos',
            'slug' => 'editar-permisos'
            ],

            [
            'nombre' => 'Validar permisos',
            'slug' => 'validar-permisos'
            ],

            [
            'nombre' => 'Borrar permisos',
            'slug' => 'borrar-permisos'
            ],

            [
            'nombre' => 'Ver lista categorías',
            'slug' => 'ver-lista-categorias'
            ],

            [
            'nombre' => 'Ver categoría',
            'slug' => 'ver-categoria'
            ],

            [
            'nombre' => 'Crear categoría',
            'slug' => 'crear-categoria'
            ],

            [
            'nombre' => 'Editar categoría estándar',
            'slug' => 'editar-categoria-estandar'
            ],

            [
            'nombre' => 'Editar categoría',
            'slug' => 'editar-categoria'
            ],

            [
            'nombre' => 'Borrar categoría',
            'slug' => 'borrar-categoria'
            ],
            [
            'nombre' => 'Borrar categoría estándar',
            'slug' => 'borrar-categoria-estandar'
            ],

            [
            'nombre' => 'Ver comercio',
            'slug' => 'ver-comercio'
            ],            

            [
            'nombre' => 'Ver lista comentarios',
            'slug' => 'ver-lista-comentarios'
            ],

            [
            'nombre' => 'Ver comentario',
            'slug' => 'ver-comentario'
            ],

            [
            'nombre' => 'Crear comentario',
            'slug' => 'crear-comentario'
            ],

            [
            'nombre' => 'Editar comentario',
            'slug' => 'editar-comentario'
            ],

            [
            'nombre' => 'Borrar comentario',
            'slug' => 'borrar-comentario'
            ],

            [
            'nombre' => 'Editar home',
            'slug' => 'editar-home'
            ],

            [
            'nombre' => 'Validar comentarios',
            'slug' => 'validar-comentarios'
            ],

            [
            'nombre' => 'Validar usuarios',
            'slug' => 'validar-usuarios'
            ],

            [
            'nombre' => 'Validar categorías',
            'slug' => 'validar-categorias'
            ],

            [
            'nombre' => 'Ver lista subcategorías',
            'slug' => 'ver-lista-subcategorias'
            ],

            [
            'nombre' => 'Ver subcategoría',
            'slug' => 'ver-subcategoria'
            ],

            [
            'nombre' => 'Crear subcategoría',
            'slug' => 'crear-subcategoria'
            ],

            [
            'nombre' => 'Editar subcategoría',
            'slug' => 'editar-subcategoria'
            ],

            [
            'nombre' => 'Borrar subcategoría',
            'slug' => 'borrar-subcategoria'
            ],

            [
            'nombre' => 'Validar subcategorías',
            'slug' => 'validar-subcategorias'
            ],

            [
            'nombre' => 'Ver subcategoría estándar',
            'slug' => 'ver-subcategoria'
            ],

            [
            'nombre' => 'Crear subcategoría estándar',
            'slug' => 'crear-subcategoria'
            ],

            [
            'nombre' => 'Editar subcategoría estándar',
            'slug' => 'editar-subcategoria'
            ],

            [
            'nombre' => 'Borrar subcategoría estándar',
            'slug' => 'borrar-subcategoria'
            ],

            [
            'nombre' => 'Validar subcategorías',
            'slug' => 'validar-subcategorias'
            ],

            [
            'nombre' => 'Ver lista promociones',
            'slug' => 'ver-lista-promociones'
            ],

            [
            'nombre' => 'Ver detalle promociones',
            'slug' => 'ver-detalle-promociones'
            ],

            [
            'nombre' => 'Crear promociones',
            'slug' => 'crear-promociones'
            ],

            [
            'nombre' => 'Editar promociones',
            'slug' => 'editar-promociones'
            ],

            [
            'nombre' => 'Validar promociones',
            'slug' => 'validar-promociones'
            ],

            [
            'nombre' => 'Borrar promociones',
            'slug' => 'borrar-promociones'
            ],


        ]);
    }
}
