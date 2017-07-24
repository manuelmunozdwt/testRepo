<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermisosRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permisos_roles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('permiso_id')->unsigned()->index('permisos_roles_permiso_id_foreign');
			$table->integer('rol_id')->unsigned()->index('permisos_roles_rol_id_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('permisos_roles');
	}

}
