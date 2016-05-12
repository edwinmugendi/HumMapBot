<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountsLogsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('acc_logs', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('merchant_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('type', 255); //Call or SMS
            $table->string('in_out'); //Incoming or outgoing
            $table->string('account_number', 255);
            $table->date('log_date');
            $table->datetime('log_datetime');
            $table->integer('seconds')->unsigned();

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
        Schema::drop('acc_logs');
    }

}
