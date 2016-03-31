<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_ip', 60);
            $table->string('body', 1000);
            $table->integer('user_id')->unsigned();
            //$table->foreign('user_id')->references('id')->on('users');
            // no integrity check, as users deleted will not cause the audit log to change
            // the audit log must be immutable
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
        Schema::drop('audit');
    }
}
