<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBloquesInicioTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('bloques_inicio', function(Blueprint $table)
		{
			$table->foreign('cupon_id2')->references('id')->on('cupones')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('cupon_id')->references('id')->on('cupones')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('bloques_inicio', function(Blueprint $table)
		{
			$table->dropForeign('bloques_inicio_cupon_id2_foreign');
			$table->dropForeign('bloques_inicio_cupon_id_foreign');
		});
	}

}
