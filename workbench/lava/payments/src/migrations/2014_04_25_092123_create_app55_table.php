<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApp55Table extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('fnc_app55', function(Blueprint $table) {
            $table->increments('id');
            //Relationships
            $table->integer('user_id')->unsigned();

            //App55
            $table->integer('ts')->unsigned();
            $table->string('sig', 255);

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
        Schema::drop('fnc_app55');
    }

}
