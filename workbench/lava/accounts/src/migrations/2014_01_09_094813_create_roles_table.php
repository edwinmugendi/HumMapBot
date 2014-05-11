<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('acc_roles', function(Blueprint $table) {
                    $table->increments('id');
                    $table->string('name', 255);
                    $table->string('description', 255);
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
        Schema::drop('acc_roles');
    }

}