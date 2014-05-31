<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('mct_locations', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('merchant_id')->unsigned();

            //About
            $table->string('name', 255);

            //Contacts
            $table->string('fax', 255);
            $table->string('phone_1', 30);
            $table->string('phone_2', 30);
            $table->string('phone_3', 30);
            $table->string('email_1', 50);
            $table->string('email_2', 50);
            $table->string('email_3', 50);

            //Location
            $table->string('address', 255);
            $table->string('postal_code', 255);
            $table->decimal('lat', 10, 6);
            $table->decimal('lng', 10, 6);

            //Loyalty Scheme
            $table->integer('loyalty_stamps');
            $table->string('currency',4);

            //Monday
            $table->string('monday_open', 255);
            $table->string('monday_close', 255);

            //Tuesday
            $table->string('tuesday_open', 255);
            $table->string('tuesday_close', 255);

            //Wednesday
            $table->string('wednesday_open', 255);
            $table->string('wednesday_close', 255);

            //Thursday
            $table->string('thursday_open', 255);
            $table->string('thursday_close', 255);

            //Friday
            $table->string('friday_open', 255);
            $table->string('friday_close', 255);

            //Saturday
            $table->string('saturday_open', 255);
            $table->string('saturday_close', 255);

            //Sunday
            $table->string('sunday_open', 255);
            $table->string('sunday_close', 255);

            //Public holidays
            $table->string('holiday_open', 255);
            $table->string('holiday_close', 255);

            //Image
            $table->text('image');

            $table->integer('views')->unsigned();
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
        Schema::drop('mct_locations');
    }

}
