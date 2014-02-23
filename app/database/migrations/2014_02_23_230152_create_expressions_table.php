<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpressionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('expressions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('text', 255)->unique();
			$table->char('char', 1);
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
		Schema::drop('expressions');
	}

}
