<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountsUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('acc_users', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('merchant_id')->unsigned();
            $table->integer('role_id')->unsigned();

            //About
            $table->string('full_name', 255);
            $table->string('phone', 255);
            $table->date('dob');
            $table->string('gender', 255);
            $table->string('referral_code', 255);

            //Identity
            $table->string('email', 255);
            $table->text('password');
            $table->string('reset_code', 255);
            $table->datetime('reset_time');
            $table->datetime('last_login');

            //Activation
            $table->string('verification_code', 255);
            $table->text('remember_token');

            //Token
            $table->string('token');

            //Push
            $table->string('device_token');
            $table->string('app_version');

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
        Schema::drop('acc_users');
    }

}
