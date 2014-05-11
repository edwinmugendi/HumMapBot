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
            $table->string('name', 255);
            $table->string('number', 255);
            $table->string('address_street', 255);
            $table->string('address_city', 255);
            $table->string('address_postal_code', 255);
            $table->string('address_country', 255);
            $table->string('token', 255);
            $table->datetime('expiry');

            //
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
