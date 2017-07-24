<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCuponesUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cupones_user', function(Blueprint $table)
		{
			$table->foreign('cupon_id')->references('id')->on('cupones')->onUpdate('RESTRICT')->onDelete('CASCADE');
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
		Schema::table('cupones_user', function(Blueprint $table)
		{
			$table->dropForeign('cupones_user_cupon_id_foreign');
			$table->dropForeign('cupones_user_user_id_foreign');
		});
	}

}
