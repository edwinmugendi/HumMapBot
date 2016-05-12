<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTransactionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('pyt_transactions', function(Blueprint $table) {
            $table->increments('id');
            //Relationships
            $table->integer('user_id')->unsigned();
            $table->integer('loan_id')->unsigned();
            $table->integer('merchant_id')->unsigned();

            //Payment
            $table->string('type', 255);
            $table->string('phone', 255);
            $table->string('currency', 255);
            $table->float('amount')->unsigned();
            $table->string('description', 255);
            $table->date('transaction_date');

            //Gateway
            $table->string('gateway', 255);
            $table->string('gateway_tran_id', 255);
            $table->string('gateway_code', 255); //New
            
            //Notification
            $table->boolean('user_smsed');
            $table->boolean('user_emailed');
            $table->boolean('user_pushed');

            $table->boolean('officer_smsed');
            $table->boolean('officer_emailed');

            //Agent
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
        Schema::drop('pyt_transactions');
    }

}
