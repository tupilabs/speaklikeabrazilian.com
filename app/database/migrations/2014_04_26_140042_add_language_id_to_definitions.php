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
			if (!Schema::hasColumn('definitions', 'language_id'))
			{
				$table->integer('language_id')->unsigned();
				$table->foreign('language_id')
			      ->references('id')->on('languages')
			      ->onDelete('cascade')
			      ->default(1); // 1 is en, there is no increments in this table, only constants
			}
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
			if (Schema::hasColumn('definitions', 'language_id'))
			{
				$table->dropForeign('language_id');
			}
		});
	}

}
