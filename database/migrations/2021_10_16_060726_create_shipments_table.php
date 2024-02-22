<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shipping_office')->nullable();
            $table->string('shipping_status');
            $table->timestamps();
        });
        Schema::create('shipment_detailes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_name');
            $table->string('client_mobile');
            $table->string('client_address');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('shipment_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->foreign('shipment_id')
                ->references('id')
                ->on('shipments')
                ->onDelete('cascade');
            $table->unsignedInteger('store_id');
            $table->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->onDelete('cascade');
            $table->integer('returned_qty')->nullable();
            $table->integer('qty');
            $table->double('cost');
            $table->double('price');
            $table->double('shipping_cost')->nullable();
            $table->string('status')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('shipment_detailes');
        Schema::dropIfExists('shipments');
    }
}
