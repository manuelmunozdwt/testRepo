<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBloquesInicioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bloques_inicio', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('tipo');
			$table->integer('cupon_id')->unsigned()->nullable()->index('bloques_inicio_cupon_id_foreign');
			$table->integer('cupon_id2')->unsigned()->nullable()->index('bloques_inicio_cupon_id2_foreign');
			$table->date('fecha_corte_cupon')->nullable();
			$table->string('enlace')->nullable();
			$table->string('enlace_dos', 150);
			$table->string('imagen')->nullable();
			$table->string('imagen_dos', 150);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bloques_inicio');
	}

}
