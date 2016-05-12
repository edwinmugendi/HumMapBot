<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansOffersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('lon_offers', function(Blueprint $table) {
            $table->increments('id');
            //Relationships
            $table->integer('merchant_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('plan_id')->unsigned();

            $table->string('currency', 255);
            $table->float('principal');

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
        Schema::drop('lon_offers');
    }

}
