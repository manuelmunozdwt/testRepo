<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPromocionesTiendasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('promociones_tiendas', function(Blueprint $table)
		{
			$table->foreign('id_promocion')->references('id')->on('promociones')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
		Schema::table('promociones_tiendas', function(Blueprint $table)
		{
			$table->dropForeign('promociones_tiendas_id_promocion_foreign');
			$table->dropForeign('promociones_tiendas_id_tienda_foreign');
		});
	}

}
