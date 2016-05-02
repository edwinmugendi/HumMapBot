<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansSchedulesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('lon_schedules', function(Blueprint $table) {
            $table->increments('id');
            //Relationships
            $table->integer('merchant_id')->unsigned();
            $table->integer('loan_id')->unsigned();
            $table->date('due_date', 255);
            $table->float('amount');

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
        Schema::drop('lon_schedules');
    }

}
