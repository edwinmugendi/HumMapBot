<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesMessagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('msg_messages', function(Blueprint $table) {
            $table->increments('id');
            $table->string('type',10);
            $table->string('code');
            $table->text('body');
            $table->integer('sender_id')->unsigned();
            $table->string('sender', 255);
            $table->integer('recipient_id')->unsigned();
            $table->string('recipient', 255);
            $table->boolean('sent');
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
        Schema::drop('msg_messages');
    }

}
