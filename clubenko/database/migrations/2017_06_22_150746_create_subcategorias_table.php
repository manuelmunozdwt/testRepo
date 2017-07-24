<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubcategoriasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subcategorias', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');
			$table->string('slug');
			$table->integer('categoria_id')->unsigned()->index('subcategorias_categoria_id_foreign');
			$table->boolean('estandar')->default(0);
			$table->boolean('confirmado')->default(0);
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('subcategorias');
	}

}
