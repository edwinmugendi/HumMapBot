<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCardsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('fnc_cards', function(Blueprint $table) {
            $table->increments('id');
            //Relationships
            $table->integer('user_id')->unsigned();

            //Card
            $table->string('gateway');
            $table->boolean('deleted_on_stripe');
            $table->integer('exp_month')->unsigned();
            $table->integer('exp_year')->unsigned();
            $table->integer('last4')->unsigned();
            $table->string('brand');
            $table->string('address_city');
            $table->string('address_zip');
            $table->string('address_country');
            $table->string('address_line1');
            $table->string('token');
            
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
        Schema::drop('fnc_cards');
    }

}
