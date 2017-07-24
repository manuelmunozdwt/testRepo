<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateValoracionesCuponesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('valoraciones_cupones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index('valoraciones_cupones_user_id_foreign');
			$table->integer('cupon_id')->unsigned()->index('valoraciones_cupones_cupon_id_foreign');
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
		Schema::drop('valoraciones_cupones');
	}

}
