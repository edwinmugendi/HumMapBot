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
            $table->integer('gateway_id')->unsigned();

            //Card
            $table->string('name');
            $table->string('number');
            $table->string('address_street');
            $table->string('address_city');
            $table->string('address_postal_code');
            $table->string('address_country');
            $table->string('token');
            $table->string('expiry');

           
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
