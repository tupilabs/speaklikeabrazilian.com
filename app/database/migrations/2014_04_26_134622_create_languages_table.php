<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('languages'))
		{
			Schema::create('languages', function(Blueprint $table)
			{
				$table->integer('id')->unsigned();
				$table->string('slug', 2);
				$table->string('description', 30)->nullable();
				$table->string('local_description', 30)->nullable();
				$table->timestamps();
				$table->engine = 'InnoDB';
				$table->primary(array('id'));
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('languages');
	}

}
