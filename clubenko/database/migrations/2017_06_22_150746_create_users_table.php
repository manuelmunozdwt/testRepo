<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('dni')->unique();
			$table->string('name');
			$table->string('apellidos', 200);
			$table->string('nombre_comercio', 255);
			$table->string('email')->unique();
			$table->string('password');
			$table->string('slug');
			$table->string('imagen');
			$table->boolean('confirmado')->default(0);
			$table->text('sobre_comercio');
			$table->string('web_comercio',100);
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('rol')->unsigned()->default(1)->index('users_rol_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
