<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveysQuestionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('svy_questions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('form_id')->unsigned();

            $table->string('title', 255);
            $table->string('name', 255);
            $table->string('type', 255);
            $table->string('regex', 255);

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
        Schema::drop('mct_organizations');
    }

}
