<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('mct_merchants', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('type')->unsigned();
            $table->integer('plan_id')->unsigned();

            //About
            $table->string('name', 255);
            $table->string('registration_number', 255);
            $table->string('tax_id', 255);
            $table->string('vat', 255);

            //Philosophy
            $table->string('vision', 255);
            $table->string('mission', 255);
            $table->string('slogan', 255);
            $table->text('about');

            //Contacts
            $table->string('landline', 255);
            $table->string('mobile', 255);
            $table->string('fax', 255);
            $table->string('email', 255);

            //Location
            $table->integer('country_id')->unsigned();
            $table->integer('town_id')->unsigned();
            $table->string('address', 255);
            $table->string('postal_code', 255);

            //Social
            $table->string('website', 255);
            $table->string('facebook', 255);
            $table->string('twitter', 255);

            //Image
            $table->text('image');

            //Transactions
            $table->string('currency', 3);
            $table->float('surcharge');

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
        Schema::drop('mct_merchants');
    }

}
