<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountsMpesaTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('acc_mpesa', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('merchant_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('type', 255); //dr or cr
            $table->integer('class')->unsigned(); //money in, money out, paybill, top up
            $table->string('tran_id', 255);
            $table->float('amount');
            $table->float('balance');
            $table->float('currency', 255);
            $table->string('account', 255);
            $table->string('account_number', 255);
            $table->date('tran_date');
            $table->datetime('tran_datetime');


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
        Schema::drop('acc_mpesa');
    }

}
