<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCuponesTiendasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cupones_tiendas', function(Blueprint $table)
		{
			$table->foreign('id_cupon')->references('id')->on('cupones')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('id_tienda')->references('id')->on('tiendas')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cupones_tiendas', function(Blueprint $table)
		{
			$table->dropForeign('cupones_tiendas_id_cupon_foreign');
			$table->dropForeign('cupones_tiendas_id_tienda_foreign');
		});
	}

}
