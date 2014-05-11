<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('pdt_products', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('location_id')->unsigned();
            $table->string('name', 255);
            $table->string('description', 255);
            $table->float('price_4X2');
            $table->float('price_4X4');
            $table->boolean('loyable');
            
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
        Schema::drop('pdt_products');
    }

}
