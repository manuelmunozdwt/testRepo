<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToValidacionesCuponesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('validaciones_cupones', function(Blueprint $table)
		{
			$table->foreign('id_cupon')->references('id')->on('cupones')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('validaciones_cupones', function(Blueprint $table)
		{
			$table->dropForeign('validaciones_cupones_id_cupon_foreign');
		});
	}

}
