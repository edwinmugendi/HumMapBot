<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocationsTimezonesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('loc_timezones', function(Blueprint $table) {
			$table->integer('id')->unsigned();
			$table->primary('id');
			$table->string('adjustment', 6);
			$table->string('name', 255);
                        
                        $table->string('ip', 50);
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
		Schema::drop('loc_timezones');
	}

}
