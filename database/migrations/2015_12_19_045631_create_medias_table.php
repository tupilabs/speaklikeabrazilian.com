<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('definition_id')->unsigned();
			$table->foreign('definition_id')->references('id')->on('definitions');
			$table->string('url', 255);
			$table->string('reason', 500);
			$table->string('email');
			$table->char('status', 1);
			$table->string('content_type', 20);
			$table->string('contributor', 50);
            $table->string('user_ip', 60)->nullable();
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
