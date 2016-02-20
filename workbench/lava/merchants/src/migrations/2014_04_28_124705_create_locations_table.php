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
            $table->text('about');

            //Contacts
            $table->string('phone', 255);
            $table->string('email', 255);

            //Social
            $table->string('website', 255);
            $table->string('facebook', 255);
            $table->string('twitter', 255);

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

            $table->decimal('lat', 13, 10);
            $table->decimal('lng', 13, 10);

            //Loyalty Scheme
            $table->integer('loyalty_stamps');
            $table->float('surcharge');

            //Monday
            $table->boolean('is_monday_open');
            $table->string('monday_opens_at', 255);
            $table->string('monday_closes_at', 255);

            //Tuesday
            $table->boolean('is_tuesday_open');
            $table->string('tuesday_opens_at', 255);
            $table->string('tuesday_closes_at', 255);

            //Wednesday
            $table->boolean('is_wednesday_open');
            $table->string('wednesday_opens_at', 255);
            $table->string('wednesday_closes_at', 255);

            //Thursday
            $table->boolean('is_thursday_open');
            $table->string('thursday_opens_at', 255);
            $table->string('thursday_closes_at', 255);

            //Friday
            $table->boolean('is_friday_open');
            $table->string('friday_opens_at', 255);
            $table->string('friday_closes_at', 255);

            //Saturday
            $table->boolean('is_saturday_open');
            $table->string('saturday_opens_at', 255);
            $table->string('saturday_closes_at', 255);

            //Sunday
            $table->boolean('is_sunday_open');
            $table->string('sunday_opens_at', 255);
            $table->string('sunday_closes_at', 255);

            //Public holidays
            $table->boolean('is_holiday_open');
            $table->string('holiday_opens_at', 255);
            $table->string('holiday_closes_at', 255);

            $table->integer('views')->unsigned();

            //Bank
            $table->boolean('pay_location');
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
        Schema::drop('mct_locations');
    }

}
