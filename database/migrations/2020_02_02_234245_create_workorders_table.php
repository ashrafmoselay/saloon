<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workorders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('store_id');
            $table->unsignedInteger('unit_id');
            $table->string('product_name');
            $table->date('date');
            $table->integer('itemqty');
            $table->timestamps();
        });
        Schema::create('workorders_detailes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('workorder_id');
            $table->unsignedInteger('raw_unit_id');
            $table->string('raw_name');
            $table->integer('totalneedqty');
            $table->string('raw_unit_text');
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
        Schema::dropIfExists('workorders_detailes');
        Schema::dropIfExists('workorders');
    }
}
