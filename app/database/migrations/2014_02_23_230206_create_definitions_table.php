<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefinitionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('definitions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('expression_id');
			$table->foreign('expression_id')->references('id')->on('expressions');
			$table->text('description', 1000);
			$table->text('example', 1000);
			$table->text('tags', 100);
			$table->char('status', 1);
			$table->text('email');
			$table->text('contributor', 50);
			$table->integer('moderator_id')->nullable();
			$table->foreign('moderator_id')->references('id')->on('users');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('definitions');
	}

}
