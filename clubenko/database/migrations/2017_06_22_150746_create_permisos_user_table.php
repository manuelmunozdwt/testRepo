<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermisosUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permisos_user', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('permiso_id')->unsigned()->index('permisos_user_permiso_id_foreign');
			$table->integer('user_id')->unsigned()->index('permisos_user_user_id_foreign');
			$table->integer('permitido')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('permisos_user');
	}

}
