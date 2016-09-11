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

            $table->integer('organization_id')->unsigned();
            $table->integer('role_id')->unsigned();

            //About
            $table->string('full_name', 255);
            $table->string('phone', 255);

            //Identity
            $table->string('email', 255);
            $table->text('security_question');
            $table->text('security_answer');
            $table->string('reset_code', 255);
            $table->datetime('reset_time');
            $table->datetime('last_login');
            $table->text('password');


            //Activation
            $table->string('verification_code', 255);
            $table->text('remember_token');

            //Token
            $table->string('token');

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
