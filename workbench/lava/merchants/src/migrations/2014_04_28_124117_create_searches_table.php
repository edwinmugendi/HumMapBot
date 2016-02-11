<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('mct_searches', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();

            $table->decimal('lat', 13, 10);
            $table->decimal('lng', 13, 10);
            $table->integer('locations_found')->unsigned();
            $table->float('radius');

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
        Schema::drop('mct_searches');
    }

}
