<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVehiclesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('acc_vehicles', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();

            $table->string('vrm', 255);
            $table->string('purpose', 255);
            $table->integer('type')->unsigned();
            $table->integer('is_default')->unsigned();

            //Vehicle Details
            $table->string('make', 255);
            $table->string('model', 255);
            $table->string('six_month_rate', 255); //The six month cost of taxing the vehicle
            $table->string('twelve_month_rate', 255); //The twelve month cost of taxing the vehicle
            $table->string('date_of_first_registration', 255); //The date the vehicle became registered with the DVLA
            $table->string('year_of_manufacture', 255); //
            $table->string('cylinder_capacity', 255); //In CC
            $table->string('co_2_emissions', 255);
            $table->string('fuel_type', 255); //Fuel type. Diesel, petrol or electric
            $table->string('tax_status', 255); //A description about the tax status
            $table->string('colour', 255);
            $table->string('type_approval', 255); //confirmation that production samples of a design will meet specified performance standards
            $table->string('wheel_plan', 255); //number of axles
            $table->string('revenue_weight', 255); //maximum gross weight
            $table->string('tax_details', 255); //status and expiry date of the tax
            $table->string('mot_details', 255); //mot status
            $table->string('taxed', 255); //A boolean value (true or false) as to whether the vehicle has a valid tax
            $table->string('mot', 255); //A boolean value (true or false) as to whether the vehicle has a valid MOT

            $table->integer('api_status');
            $table->string('api_message', 255);

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
        Schema::drop('acc_vehicles');
    }

}
