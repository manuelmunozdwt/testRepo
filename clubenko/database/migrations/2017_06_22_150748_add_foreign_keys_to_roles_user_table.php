<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToRolesUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('roles_user', function(Blueprint $table)
		{
			$table->foreign('id_rol')->references('id')->on('roles')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('id_usuario')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('roles_user', function(Blueprint $table)
		{
			$table->dropForeign('roles_user_id_rol_foreign');
			$table->dropForeign('roles_user_id_usuario_foreign');
		});
	}

}
