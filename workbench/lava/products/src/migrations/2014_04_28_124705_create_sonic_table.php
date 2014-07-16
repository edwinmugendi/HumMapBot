<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSonicTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('pdt_sonic', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('points')->unsigned();
            $table->string('event_id', 255);
            $table->string('commission_origin', 255);
            $table->string('application_id', 255);
            $table->string('item_name', 255);
            $table->string('signature', 255);
            $table->string('timestamp', 255);
            $table->boolean('negated');
            
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
        Schema::drop('pdt_sonic');
    }

}
