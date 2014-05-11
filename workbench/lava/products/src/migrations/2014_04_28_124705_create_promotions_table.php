<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('pdt_promotions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('location_id')->unsigned();

            $table->string('code', 255);
            $table->string('description', 255);
            $table->integer('type')->unsigned();
            $table->integer('value')->unsigned();

            $table->boolean('new_customer');
            $table->datetime('expiry_date');

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
        Schema::drop('pdt_promotions');
    }

}
