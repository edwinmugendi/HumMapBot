<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferralsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('pdt_referrals', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('referee_id')->unsigned();
            $table->integer('referrer_id')->unsigned();
            $table->integer('workflow')->unsigned();
            $table->string('referral_code', 255);
            $table->integer('promotion_id')->unsigned();

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
        Schema::drop('pdt_referrals');
    }

}
