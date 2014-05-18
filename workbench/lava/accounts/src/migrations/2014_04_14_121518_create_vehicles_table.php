<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVehiclesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('acc_vehicles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('vrm', 255);
            $table->string('type', 3);
            $table->string('combined_make', 255);
            $table->string('model_range_desc', 255);
            $table->string('drive_type', 255);
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
        Schema::drop('acc_vehicles');
    }

}
