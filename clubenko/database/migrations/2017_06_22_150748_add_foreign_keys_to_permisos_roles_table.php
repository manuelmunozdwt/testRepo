<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPermisosRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('permisos_roles', function(Blueprint $table)
		{
			$table->foreign('permiso_id')->references('id')->on('permisos')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('rol_id')->references('id')->on('roles')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('permisos_roles', function(Blueprint $table)
		{
			$table->dropForeign('permisos_roles_permiso_id_foreign');
			$table->dropForeign('permisos_roles_rol_id_foreign');
		});
	}

}
