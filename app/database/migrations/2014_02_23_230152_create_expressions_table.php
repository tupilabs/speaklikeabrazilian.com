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
			$table->string('text', 255)->unique();
			$table->char('char', 1);
			$table->string('contributor', 50);
			$table->integer('moderator_id')->nullable();
			$table->timestamps();
			$table->engine = 'InnoDB';
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
