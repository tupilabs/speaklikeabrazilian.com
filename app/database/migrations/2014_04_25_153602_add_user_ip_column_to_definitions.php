<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIpColumnToDefinitions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('definitions', function(Blueprint $table)
		{
			$table->string('user_ip', 50)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('definitions', function(Blueprint $table)
		{
			if (Schema::hasColumn('definitions', 'user_ip'))
			{
				$table->dropColumn('user_ip');
			}
		});
	}

}
