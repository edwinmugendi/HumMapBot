<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansPlansTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('lon_plans', function(Blueprint $table) {
            $table->increments('id');
            //Relationships
            $table->integer('merchant_id')->unsigned();
            $table->integer('period')->unsigned();
            $table->string('period_cycle', 255); //days, weeks, months
            $table->float('interest_rate');
            $table->integer('pay_every')->unsigned();
            $table->string('cycle', 255); //days, weeks, months
            $table->integer('amount_from')->unsigned();
            $table->integer('amount_to')->unsigned();

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
        Schema::drop('lon_plans');
    }

}
