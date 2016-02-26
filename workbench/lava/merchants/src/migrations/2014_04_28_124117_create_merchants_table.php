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
            $table->integer('plan_id')->unsigned();
            $table->integer('default')->unsigned();
            $table->integer('user_id')->unsigned();

            //About
            $table->string('name', 255);
            $table->string('reg_no', 255);
            $table->string('tax_id', 255);

            //Contacts
            $table->string('phone', 255);
            $table->string('email', 255);

            //Location
            $table->string('street', 255);
            $table->string('city', 255);
            $table->string('province', 255);
            $table->string('postal_code', 255);
            $table->string('country_id', 255);
            
            //Currency
            $table->integer('currency_id')->unsigned();
            $table->string('date_format', 10);
            $table->integer('timezone_id');

            //Social
            $table->string('website', 255);
            $table->string('facebook', 255);
            $table->string('twitter', 255);

            //Bank
            $table->string('bank_name', 255);
            $table->string('bank_sort_code', 255);
            $table->string('bank_account_name', 255);
            $table->string('bank_account_number', 255);
            $table->string('bank_postal_code', 255);


            $table->integer('workflow')->unsigned();
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
        Schema::drop('mct_merchants');
    }

}
