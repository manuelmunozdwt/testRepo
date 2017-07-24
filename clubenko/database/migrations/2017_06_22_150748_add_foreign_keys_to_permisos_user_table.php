<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPermisosUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('permisos_user', function(Blueprint $table)
		{
			$table->foreign('permiso_id')->references('id')->on('permisos')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('permisos_user', function(Blueprint $table)
		{
			$table->dropForeign('permisos_user_permiso_id_foreign');
			$table->dropForeign('permisos_user_user_id_foreign');
		});
	}

}
