<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediaMediaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('mda_media', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('mediable_id')->unsigned();
            $table->string('mediable_type', 255);
            $table->string('controller_type', 255);
            $table->string('type', 255);
            $table->string('name', 255);
            $table->string('original_name', 255); //New
            $table->string('extension', 255);
            $table->integer('main_size')->unsigned();
            $table->integer('thumbnail_size')->unsigned();
            $table->string('description', 255);
            $table->boolean('is_thumbnailed');
            $table->boolean('is_image'); //New
            $table->boolean('is_resized');
            $table->integer('order')->unsigned();
            $table->string('refresh_key', 255);

            $table->string('agent', 50);
            $table->string('ip', 50);
            $table->integer('status')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('mda_media');
    }

}
