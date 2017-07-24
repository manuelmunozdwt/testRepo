<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('roles_user', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_usuario')->unsigned()->index('roles_user_id_usuario_foreign');
			$table->integer('id_rol')->unsigned()->index('roles_user_id_rol_foreign');
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
		Schema::drop('roles_user');
	}

}
