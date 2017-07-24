<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddForeignKeysToPromocionesDescargasUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('promociones_descargas_user', function(Blueprint $table)
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
		Schema::table('promociones_descargas_user', function(Blueprint $table)
		{
			$table->dropForeign('promociones_user_user_id_foreign');
			$table->dropForeign('promociones_user_promocion_id_foreign');
		});
	}

}