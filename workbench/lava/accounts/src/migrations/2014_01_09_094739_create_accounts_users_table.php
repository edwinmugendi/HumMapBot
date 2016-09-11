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
            $table->string('alternative_phone', 255);
            $table->string('gender', 255);
            $table->string('referral_code', 255);
            $table->string('national_id', 255);
            $table->integer('heard_from')->unsigned(); //Friend, Family, Facebook, Google Play Store, Other
            $table->string('other_heard_from', 255);
            $table->string('own_phone', 5);
            $table->string('new_used_phone', 5);
            $table->string('used_phone_for', 5); //Less than 1 month, 1-3 months, 3-6 months, 6-12 months, 1-3 years, 3+ years
            $table->string('have_job', 5);
            $table->string('self_employed', 5);
            $table->string('student', 5);
            $table->string('no_income', 5);
            $table->string('education', 255); //No, Primary, Sec/high, college / university/ masters/phd
            $table->string('income_source', 255);
            $table->date('income_from');
            $table->float('income_amount');
            $table->string('income_per');//daily, weekly, fortnight, monthly, semi-annually, annually
            $table->string('always_earn_this', 5);
            
            //Identity
            $table->string('email', 255);
            $table->text('security_question');
            $table->text('security_answer');
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
