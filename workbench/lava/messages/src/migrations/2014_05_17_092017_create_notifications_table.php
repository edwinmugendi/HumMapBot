<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('msg_notifications', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('controller_id');
            $table->string('controller_type', 255);
            $table->boolean('email');
            $table->boolean('push');
            $table->boolean('sms');
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
        Schema::drop('msg_notifications');
    }

}
