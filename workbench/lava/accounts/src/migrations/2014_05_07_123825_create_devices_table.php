<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDevicesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('acc_devices', function(Blueprint $table) {
            $table->increments('id');
            //Relationships
            $table->integer('user_id')->unsigned();
            $table->string('os');
            $table->string('manufacturer');
            $table->string('model');
            $table->string('version');
            $table->string('app_version');
            $table->string('unid');
            $table->text('push_token');

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
        Schema::drop('acc_devices');
    }

}
