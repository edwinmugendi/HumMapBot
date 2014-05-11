<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('acc_users', function(Blueprint $table) {
            $table->increments('id');

            //About
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('phone', 255);
            $table->datetime('dob', 255);
            $table->string('gender', 255);

            //Identity
            $table->string('email', 255);
            $table->string('username', 255);
            $table->text('password');
            $table->string('reset_code', 255);
            $table->datetime('reset_time');
            $table->datetime('last_login');
            $table->string('ip_address', 255);

            //Address
            $table->string('address', 255);
            $table->string('postal_code', 255);

            //Activation
            $table->string('verification_code', 255);

            //Token
            $table->string('token', 255);

            //VRM
            $table->string('default_vrm', 255);

            //Facebook
            $table->integer('fb_uid');

            //Location
            $table->float('lat');
            $table->float('lng');

            //APP55
            $table->string('card', 255);
            
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
