<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToValoracionesCuponesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('valoraciones_cupones', function(Blueprint $table)
		{
			$table->foreign('cupon_id')->references('id')->on('cupones')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('valoraciones_cupones', function(Blueprint $table)
		{
			$table->dropForeign('valoraciones_cupones_user_id_foreign');
			$table->dropForeign('valoraciones_cupones_cupon_id_foreign');
		});
	}

}
