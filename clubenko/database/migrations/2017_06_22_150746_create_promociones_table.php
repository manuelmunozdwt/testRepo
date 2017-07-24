<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePromocionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('promociones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('titulo');
			$table->text('descripcion', 65535);
			$table->string('descripcion_corta', 140);
			$table->text('condiciones');
			$table->string('imagen');
			$table->string('logo')->default('logo');
			$table->string('slug');
			$table->string('codigo');
			$table->date('fecha_inicio');
			$table->date('fecha_fin');
			$table->boolean('confirmado');
			$table->integer('descargas')->default(0);
			$table->integer('categoria_id')->unsigned()->index('promociones_categoria_id_foreign');
			$table->integer('subcategoria_id')->unsigned()->nullable()->index('promociones_subcategoria_id_foreign');
			$table->integer('filtro_id')->unsigned()->index('promociones_filtro_id_foreign');
			$table->integer('visitas');
			$table->integer('valoracion');
			$table->float('precio');
			$table->float('precio_descuento');
			$table->boolean('reserva');
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('promociones');
	}

}
