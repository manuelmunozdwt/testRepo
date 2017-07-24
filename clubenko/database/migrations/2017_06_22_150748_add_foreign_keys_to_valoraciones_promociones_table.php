<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToValoracionesPromocionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('valoraciones_promociones', function(Blueprint $table)
		{
			$table->foreign('promocion_id')->references('id')->on('promociones')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
		Schema::table('valoraciones_promociones', function(Blueprint $table)
		{
			$table->dropForeign('valoraciones_promociones_user_id_foreign');
			$table->dropForeign('valoraciones_promociones_promocion_id_foreign');
		});
	}

}
