<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePromocionesTiendasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('promociones_tiendas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_tienda')->unsigned()->index('promociones_tiendas_id_tienda_foreign');
			$table->integer('id_promocion')->unsigned()->index('promociones_tiendas_id_cupon_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('promociones_tiendas');
	}

}
