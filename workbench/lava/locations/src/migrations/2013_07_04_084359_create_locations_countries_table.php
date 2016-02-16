<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocationsCountriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('loc_countries', function(Blueprint $table) {
            $table->string('id', 2);
            $table->primary('id');
            $table->string('currency', 3);
            $table->string('language', 10);
            $table->string('name', 100);
            $table->integer('calling_code');
            $table->string('date_format', 10);
            $table->string('currency_format', 10);
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->boolean('we_in');
            $table->boolean('is_popular');

            $table->string('ip', 50);
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
        Schema::drop('loc_countries');
    }

}
