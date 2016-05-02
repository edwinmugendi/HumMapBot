<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('fnc_transactions', function(Blueprint $table) {
            $table->increments('id');
            //Relationships
            $table->integer('user_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('location_id')->unsigned();
            $table->integer('merchant_id')->unsigned();
            $table->integer('promotion_id')->unsigned();

            //Payment
            $table->float('amount')->unsigned();
            $table->float('refund')->unsigned(); //New
            $table->string('currency_id', 3);
            $table->string('description', 255);
            $table->date('transaction_date');

            //Card Used
            $table->string('card_used', 255);
            $table->string('card_token', 255);

            //VRM
            $table->integer('vehicle_id')->unsigned();
            $table->string('vrm', 255);

            //Loyalty Stamps
            $table->integer('stamps_issued');

            //Location
            $table->decimal('lat', 13, 10);
            $table->decimal('lng', 13, 10);

            //Gateway
            $table->string('gateway', 255);
            $table->string('gateway_tran_id', 255);
            $table->string('gateway_code', 255); //New
            //Notification
            $table->boolean('user_smsed');
            $table->boolean('user_emailed');
            $table->boolean('user_pushed');

            $table->boolean('merchant_smsed');
            $table->boolean('merchant_emailed');

            //Agent
            $table->string('agent', 255);
            $table->string('ip', 255);
            $table->integer('workflow')->unsigned();
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
        Schema::drop('fnc_transactions');
    }

}
