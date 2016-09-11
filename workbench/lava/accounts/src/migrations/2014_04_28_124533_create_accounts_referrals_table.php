<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsReferralsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('acc_referrals', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('referee_id')->unsigned();
            $table->integer('referrer_id')->unsigned();
            $table->integer('workflow')->unsigned();
            $table->string('referral_code', 255);
            $table->integer('transaction_id')->unsigned();

            $table->boolean('referee_smsed');
            $table->boolean('referee_pushed');
            $table->boolean('referee_emailed');
            $table->boolean('referrer_smsed');
            $table->boolean('referrer_pushed');
            $table->boolean('referrer_emailed');

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
        Schema::drop('acc_referrals');
    }

}
