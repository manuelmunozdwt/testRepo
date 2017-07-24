<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateValidacionesCuponesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('validaciones_cupones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_cupon')->unsigned()->index('validaciones_cupones_id_cupon_foreign');
			$table->text('mensaje', 65535);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('validaciones_cupones');
	}

}
