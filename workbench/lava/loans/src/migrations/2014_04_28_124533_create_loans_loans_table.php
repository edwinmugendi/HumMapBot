<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansLoansTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('lon_loans', function(Blueprint $table) {
            $table->increments('id');

            //Relationships
            $table->integer('merchant_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('plan_id')->unsigned();
            $table->integer('officer_id')->unsigned();
            $table->string('use', 255); //Personal or Business
            $table->string('purpose', 255);
            $table->string('outstanding_loan', 255);
            $table->text('description');

            $table->string('currency', 255);
            $table->float('principal');
            $table->float('interest');
            $table->float('interest_rate');
            $table->float('balance');
            $table->boolean('on_schedule');
            $table->date('disbursement_date');
            $table->date('due_date');
            $table->float('instalment');
            $table->integer('instalments')->unsigned();
            $table->integer('period')->unsigned();
            $table->string('period_cycle', 255); //days, weeks, months
            $table->integer('pay_every')->unsigned();
            $table->string('cycle', 255); //days, weeks, months

            $table->text('score_mpesa');
            $table->text('score_call');
            $table->text('score_sms');
            $table->text('score');

            $table->string('workflow', 255);
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
        Schema::drop('lon_loans');
    }

}
