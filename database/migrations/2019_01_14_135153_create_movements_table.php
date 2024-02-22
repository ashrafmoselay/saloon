<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('store_from_id');
            $table->unsignedInteger('store_to_id');
            $table->unsignedInteger('product_id');
            $table->integer('qty');

            $table->foreign('product_id')
                ->references('id')
                ->on('products');
            $table->foreign('store_from_id')
                ->references('id')
                ->on('stores');
            $table->foreign('store_to_id')
                ->references('id')
                ->on('stores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movements');
    }
}
