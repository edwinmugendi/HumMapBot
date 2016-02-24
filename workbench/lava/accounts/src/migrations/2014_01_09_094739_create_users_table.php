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

            $table->integer('merchant_id')->unsigned();
            $table->integer('role_id')->unsigned();

            //About
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('phone', 255);
            $table->date('dob');
            $table->string('gender', 255);

            //Identity
            $table->string('email', 255);
            $table->text('password');
            $table->string('reset_code', 255);
            $table->datetime('reset_time');
            $table->datetime('last_login');

            //Address
            $table->string('address', 255);
            $table->string('postal_code', 255);

            //Activation
            $table->string('verification_code', 255);

            //Token
            $table->string('token');

            //VRM
            $table->integer('vehicle_id');

            //Card
            $table->integer('card_id');

            //Facebook
            $table->string('fb_uid', 255);

            //Location
            $table->decimal('lat', 13, 10);
            $table->decimal('lng', 13, 10);

            //Stripe
            $table->string('stripe_id');

            //Sonic
            $table->integer('points');

            //Notifications
            $table->boolean('notify_sms');
            $table->boolean('notify_push');
            $table->boolean('notify_email');

            //Push
            $table->string('os');
            $table->string('device_token');
            $table->string('app_version');

            $table->text('remember_token');
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
