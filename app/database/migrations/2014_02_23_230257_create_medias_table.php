<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('medias', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('definition_id');
			$table->foreign('definition_id')->references('id')->on('definitions');
			$table->text('url', 255);
			$table->text('reason', 500);
			$table->text('email');
			$table->char('status', 1);
			$table->text('content_type', 20);
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
		Schema::drop('medias');
	}

}
