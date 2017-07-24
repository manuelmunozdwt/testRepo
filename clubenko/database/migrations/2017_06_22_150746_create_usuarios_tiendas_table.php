<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsuariosTiendasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usuarios_tiendas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_usuario')->unsigned()->index('usuarios_tiendas_id_usuario_foreign');
			$table->integer('id_tienda')->unsigned()->index('usuarios_tiendas_id_tienda_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('usuarios_tiendas');
	}

}
