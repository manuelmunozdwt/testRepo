<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTiendasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tiendas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->string('logo');
			$table->string('pantone');
			$table->string('slug');
			$table->string('direccion');
			$table->integer('provincia_id')->unsigned()->index('provincia');
			$table->string('telefono');
			$table->string('web');
			$table->string('latitud');
			$table->string('longitud');
			$table->boolean('confirmado');
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
		Schema::drop('tiendas');
	}

}
