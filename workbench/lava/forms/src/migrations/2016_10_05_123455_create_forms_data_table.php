<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormsDataTable extends Migration {

/**
* Run the migrations.
*
* @return void
*/
public function up() {

Schema::create('frm_data', function(Blueprint $table) {
//System fields
$table->increments('id');
$table->integer('organization_id')->unsigned();
$table->integer('user_id')->unsigned();
$table->integer('session_id')->unsigned();
$table->integer('form_id')->unsigned();
$table->string('names', 255);
$table->string('channel_chat_id', 255);
$table->string('channel', 255);
//Form fields
            $table->string('full_name', 255);
                $table->string('age', 255);
                $table->string('height', 255);
                $table->string('gender', 255);
                $table->decimal('latitude', 10, 6);
                $table->decimal('longitude', 10, 6);
    
//System fields
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
Schema::drop('frm_data');
}
}
