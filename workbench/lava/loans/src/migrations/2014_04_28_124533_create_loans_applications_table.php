<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansApplicationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('lon_applications', function(Blueprint $table) {
            $table->increments('id');

            //Relationships
            $table->integer('merchant_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('loan_id')->unsigned();
            $table->integer('loan_use')->unsigned();
            $table->integer('loan_purpose')->unsigned();
            $table->string('outstanding_loan',255);
            $table->text('description');
            $table->string('workflow', 255);
            $table->float('workflow_text');

            //Scores
            $table->text('score_mpesa');
            $table->text('score_call');
            $table->text('score_sms');
            $table->text('score');
            
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
        Schema::drop('lon_applications');
    }

}
