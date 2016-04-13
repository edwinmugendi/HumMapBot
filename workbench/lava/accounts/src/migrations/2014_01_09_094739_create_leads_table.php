<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLeadsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('acc_leads', function(Blueprint $table) {
            $table->increments('id');

            $table->string('full_name', 255);
            $table->string('email', 255);
            $table->string('organization', 255);
            $table->string('phone', 255);
            $table->string('town', 255);
            $table->integer('country_id');
            $table->string('note', 255);
            $table->integer('action')->unsigned();
            $table->integer('source')->unsigned();
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
        Schema::drop('acc_leads');
    }

}
