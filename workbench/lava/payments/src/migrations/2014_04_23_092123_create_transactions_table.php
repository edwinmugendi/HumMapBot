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
            $table->integer('promotion_id')->unsigned();

            //Payment
            $table->float('amount')->unsigned();
            $table->float('refund')->unsigned(); //New
            $table->string('currency', 3);
            $table->string('description', 255);

            //Card Used
            $table->string('card_used', 255);
            $table->string('card_token', 255);
            
            //VRM
            $table->string('vrm', 255);
            
            //Loyalty Stamps
            $table->integer('stamps_issued');
            
            //Location
            $table->decimal('lat', 10, 6);
            $table->decimal('lng', 10, 6);

            //Gateway
            $table->string('gateway', 255);
            $table->string('gateway_tran_id', 255);
            $table->string('gateway_code', 255); //New
            //Agent
            $table->string('agent', 255);

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
