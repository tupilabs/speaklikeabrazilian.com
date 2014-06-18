<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLanguageIdToDefinitions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('definitions', function(Blueprint $table)
		{
			$table->integer('language_id')->unsigned()->default(1); // 1 is en, there is no increments in this table, only constants;
			$table->foreign('language_id')
		      ->references('id')->on('languages')
		      ->onDelete('cascade');
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
			$table->dropForeign('language_id');
			$table->dropColumn('language_id');
		});
	}

}
