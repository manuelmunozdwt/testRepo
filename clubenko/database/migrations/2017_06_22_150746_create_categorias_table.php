<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categorias', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->string('slug');
			$table->string('imagen');
			$table->integer('cupon_destacado_uno_id')->unsigned()->index('cupon_destacado_uno_id');
			$table->integer('cupon_destacado_dos_id')->unsigned()->index('cupon_destacado_dos_id');
			$table->string('banner_categoria', 100);
			$table->string('banner_nombre', 100);
			$table->string('banner_alt', 100);
			$table->string('banner_enlace', 150);
			$table->boolean('estandar')->default(0);
			$table->boolean('confirmado')->default(0);
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
		Schema::drop('categorias');
	}

}
