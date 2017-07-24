<?php

use Illuminate\Database\Seeder;

class SubcategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subcategorias')->insert([
            [
             'nombre' => 'Complementos',
             'slug' => 'complementos',
             'categoria_id' => '1',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Ropa',
             'slug' => 'ropa',
             'categoria_id' => '1',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Zapatería',
             'slug' => 'zapateria',
             'categoria_id' => '1',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Infantil',
             'slug' => 'infantil',
             'categoria_id' => '1',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Museos',
             'slug' => 'museos',
             'categoria_id' => '2',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Espectáculos',
             'slug' => 'espectaculos',
             'categoria_id' => '2',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Pubs y Discotecas',
             'slug' => 'pubs-y-discotecas',
             'categoria_id' => '2',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Libros, Música y Películas',
             'slug' => 'libros-musica-peliculas',
             'categoria_id' => '2',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Eventos',
             'slug' => 'eventos',
             'categoria_id' => '2',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Parques temáticos',
             'slug' => 'parques-tematicos',
             'categoria_id' => '2',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Cines',
             'slug' => 'cines',
             'categoria_id' => '2',
             'estandar' => '1',
             'confirmado' => '1'
             ],

        	[
        	 'nombre' => 'Nacional',
        	 'slug' => 'nacional',
        	 'categoria_id' => '3',
             'estandar' => '1',
             'confirmado' => '1'
        	 ],

        	[
        	 'nombre' => 'Internacional',
        	 'slug' => 'internacional',
        	 'categoria_id' => '3',
             'estandar' => '1',
             'confirmado' => '1'
        	 ],

            [
             'nombre' => 'Asiática',
             'slug' => 'asiatica',
             'categoria_id' => '3',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Italiana',
             'slug' => 'italiana',
             'categoria_id' => '3',
             'estandar' => '1',
             'confirmado' => '1'
             ],

        	[
        	 'nombre' => 'Cafeterías y Heladerías',
        	 'slug' => 'cafeterias-y-heladerias',
        	 'categoria_id' => '3',
             'estandar' => '1',
             'confirmado' => '1'
        	 ],

            [
             'nombre' => 'Alquiler de vehículos',
             'slug' => 'alquiler-de-vehiculos',
             'categoria_id' => '4',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Viajes',
             'slug' => 'viajes',
             'categoria_id' => '4',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Peluquerías',
             'slug' => 'peluquerias',
             'categoria_id' => '6',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Dentistas',
             'slug' => 'dentistas',
             'categoria_id' => '6',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Farmacia',
             'slug' => 'farmacia',
             'categoria_id' => '6',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Perfumería y Cosmética',
             'slug' => 'perfumeria-y-cosmetica',
             'categoria_id' => '6',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Centros de estética',
             'slug' => 'centros-de-estetica',
             'categoria_id' => '6',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Ópticas',
             'slug' => 'opticas',
             'categoria_id' => '6',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Herbolarios y Nutrición',
             'slug' => 'herbolarios-y-nutricion',
             'categoria_id' => '6',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Servicios médicos',
             'slug' => 'servicios-medicos',
             'categoria_id' => '6',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Ortopedias',
             'slug' => 'ortopedias',
             'categoria_id' => '6',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Spas',
             'slug' => 'spas',
             'categoria_id' => '6',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Parafarmacias',
             'slug' => 'parafarmacias',
             'categoria_id' => '6',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Electrónica',
             'slug' => 'electronica',
             'categoria_id' => '7',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Informática',
             'slug' => 'informatica',
             'categoria_id' => '7',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Fotografía',
             'slug' => 'fotografia',
             'categoria_id' => '7',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Videojuegos',
             'slug' => 'videojuegos',
             'categoria_id' => '7',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Joyerías y Relojerías',
             'slug' => 'joyerias-y-relojerias',
             'categoria_id' => '8',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Tiendas de regalos',
             'slug' => 'tiendas-de-regalos',
             'categoria_id' => '8',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Papelerías',
             'slug' => 'papelerias',
             'categoria_id' => '8',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Floristerías',
             'slug' => 'floristerias',
             'categoria_id' => '8',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Jugueterías',
             'slug' => 'jugueterias',
             'categoria_id' => '8',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Tiendas de Alimentación',
             'slug' => 'tiendas-de-alimentacion',
             'categoria_id' => '9',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Supermercados',
             'slug' => 'supermercados',
             'categoria_id' => '9',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Gourmet',
             'slug' => 'gourmet',
             'categoria_id' => '9',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Vinos y Licores',
             'slug' => 'vinos-y-licores',
             'categoria_id' => '9',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Pastelerías',
             'slug' => 'pastelerias',
             'categoria_id' => '9',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Tiendas de decoración',
             'slug' => 'tiendas-de-decoracion',
             'categoria_id' => '10',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Arte y Antigüedades',
             'slug' => 'arte-y-antiguedades',
             'categoria_id' => '10',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Iluminación',
             'slug' => 'iluminacion',
             'categoria_id' => '10',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Ferreterías',
             'slug' => 'ferreterias',
             'categoria_id' => '10',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Terraza y Jardín',
             'slug' => 'terraza-y-jardin',
             'categoria_id' => '10',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Electrodomésticos',
             'slug' => 'electrodomesticos',
             'categoria_id' => '10',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Otros',
             'slug' => 'otros-hogar-y-decoracion',
             'categoria_id' => '10',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Gimnasio',
             'slug' => 'gimnasio',
             'categoria_id' => '11',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Equipamiento deportivo',
             'slug' => 'equipamiento-deportivo',
             'categoria_id' => '11',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Caza',
             'slug' => 'caza',
             'categoria_id' => '11',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Golf',
             'slug' => 'golf',
             'categoria_id' => '11',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Aventura',
             'slug' => 'aventura',
             'categoria_id' => '11',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Otros',
             'slug' => 'otros-deporte-y-aventura',
             'categoria_id' => '11',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Motor',
             'slug' => 'motor',
             'categoria_id' => '12',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Talleres',
             'slug' => 'talleres',
             'categoria_id' => '12',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Motos',
             'slug' => 'motos',
             'categoria_id' => '12',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Equipamiento',
             'slug' => 'equipamiento',
             'categoria_id' => '12',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Tintorería',
             'slug' => 'tintoreria',
             'categoria_id' => '14',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Zapateros',
             'slug' => 'zapateros',
             'categoria_id' => '14',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Arreglos de ropa',
             'slug' => 'arreglos-de-ropa',
             'categoria_id' => '14',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Seguros',
             'slug' => 'seguros',
             'categoria_id' => '14',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Gestorías y Abogacía',
             'slug' => 'gestorias-y-abogacia',
             'categoria_id' => '14',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Otros',
             'slug' => 'otros-servicios-profesionales',
             'categoria_id' => '14',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Tiendas',
             'slug' => 'tiendas',
             'categoria_id' => '15',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Peluquerías caninas',
             'slug' => 'peluquerias-caninas',
             'categoria_id' => '15',
             'estandar' => '1',
             'confirmado' => '1'
             ],

            [
             'nombre' => 'Veterinarios',
             'slug' => 'veterinarios',
             'categoria_id' => '15',
             'estandar' => '1',
             'confirmado' => '1'
             ]

        ]);    
    }
}
