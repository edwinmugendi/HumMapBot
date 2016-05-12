<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountsChatsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('acc_chats', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('merchant_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('sender_id')->unsigned();
            $table->integer('recipient_id')->unsigned();
            $table->text('message');
            $table->string('in_out'); //Incoming or outgoing
            $table->integer('workflow')->unsigned();

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
        Schema::drop('acc_chats');
    }

}
