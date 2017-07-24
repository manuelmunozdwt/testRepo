<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCuponesTiendasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cupones_tiendas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_tienda')->unsigned()->index('cupones_tiendas_id_tienda_foreign');
			$table->integer('id_cupon')->unsigned()->index('cupones_tiendas_id_cupon_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cupones_tiendas');
	}

}
