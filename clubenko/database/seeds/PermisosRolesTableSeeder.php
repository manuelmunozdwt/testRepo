<?php

use Illuminate\Database\Seeder;

class PermisosRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permisos_roles')->insert([
            //permisos usuario
            ['rol_id' => '1',        
            'permiso_id' => '2'],  

            ['rol_id' => '1',        
            'permiso_id' => '4'],  

            ['rol_id' => '1',        
            'permiso_id' => '14'],

            ['rol_id' => '1',        
            'permiso_id' => '31'],
            
            ['rol_id' => '1',        
            'permiso_id' => '32'],     

            ['rol_id' => '1',        
            'permiso_id' => '36'],     

            ['rol_id' => '1',        
            'permiso_id' => '39'],     

            ['rol_id' => '1',        
            'permiso_id' => '41'],     

            //permisos comercio
            ['rol_id' => '2',        
            'permiso_id' => '2'],
            
            ['rol_id' => '2', 

            'permiso_id' => '4'],

            ['rol_id' => '2',        
            'permiso_id' => '7'],

            ['rol_id' => '2',        
            'permiso_id' => '9'],

            ['rol_id' => '2',        
            'permiso_id' => '10'],

            ['rol_id' => '2',        
            'permiso_id' => '13'],

            ['rol_id' => '2',        
            'permiso_id' => '14'],

            ['rol_id' => '2',        
            'permiso_id' => '15'],

            ['rol_id' => '2',        
            'permiso_id' => '16'],
            
            ['rol_id' => '2',        
            'permiso_id' => '33'],

            ['rol_id' => '2',        
            'permiso_id' => '35'],

            ['rol_id' => '2',        
            'permiso_id' => '36'],

            ['rol_id' => '2',        
            'permiso_id' => '50'],


        ]);
        //permisos administrador
        foreach(range(1, 64)as $index){
            DB::table('permisos_roles')->insert([
                'rol_id' => '3',
                'permiso_id' => $index
            ]);
        }
    }
}
