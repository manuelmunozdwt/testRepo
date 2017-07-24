<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCuponesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cupones', function(Blueprint $table)
		{
			$table->foreign('categoria_id')->references('id')->on('categorias')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('filtro_id')->references('id')->on('filtros')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('subcategoria_id')->references('id')->on('subcategorias')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cupones', function(Blueprint $table)
		{
			$table->dropForeign('cupones_categoria_id_foreign');
			$table->dropForeign('cupones_filtro_id_foreign');
			$table->dropForeign('cupones_subcategoria_id_foreign');
		});
	}

}
