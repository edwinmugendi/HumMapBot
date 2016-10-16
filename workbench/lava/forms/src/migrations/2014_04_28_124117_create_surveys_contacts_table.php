<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveysContactsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('frm_contacts', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->integer('session_id')->unsigned();
            $table->integer('form_id')->unsigned();
            $table->string('names', 255);
            $table->string('channel_chat_id', 255);
            $table->string('channel', 255);

            $table->string('full_name', 255);
            $table->string('age', 255);
            $table->string('phone', 255);
            $table->string('gender', 255);
            $table->float('height');
            $table->decimal('lat', 10, 6);
            $table->decimal('lng', 10, 6);
            $table->string('food_chicken', 255);
            $table->string('food_fish', 255);
            $table->string('workflow', 255);

            $table->string('agent', 255);
            $table->string('ip', 255);
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
        Schema::drop('frm_contacts');
    }

}
