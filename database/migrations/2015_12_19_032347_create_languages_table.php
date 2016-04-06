<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use SLBR\Models\Language;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->primary(array('id'));
            $table->string('slug', 2);
            $table->string('description', 30)->nullable();
            $table->string('local_description', 30)->nullable();
            $table->timestamps();
        });

        Language::create(
            array(
                'id' => 1,
                'slug' => 'en',
                'description' => 'English',
                'local_description' => 'English'
            )
        );

        Language::create(
            array(
                'id' => 2,
                'slug' => 'es',
                'description' => 'Spanish',
                'local_description' => 'Espa&ntilde;ol'
            )
        );
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
