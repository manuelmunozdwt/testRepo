<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUsuariosTiendasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('usuarios_tiendas', function(Blueprint $table)
		{
			$table->foreign('id_tienda')->references('id')->on('tiendas')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('id_usuario')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('usuarios_tiendas', function(Blueprint $table)
		{
			$table->dropForeign('usuarios_tiendas_id_tienda_foreign');
			$table->dropForeign('usuarios_tiendas_id_usuario_foreign');
		});
	}

}
