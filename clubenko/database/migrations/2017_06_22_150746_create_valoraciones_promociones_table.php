<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateValoracionesPromocionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('valoraciones_promociones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('valoraciones_promociones_user_id_foreign');
			$table->integer('promocion_id')->unsigned()->index('valoraciones_promociones_promocion_id_foreign');
			$table->integer('valoracion');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('valoraciones_promociones');
	}

}
