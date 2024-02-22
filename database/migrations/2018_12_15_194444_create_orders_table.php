<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('client_id');
            $table->foreign('client_id')
                ->references('id')
                ->on('persons')
                ->onDelete('cascade');
            $table->unsignedInteger('sale_id')->nullable();
            $table->foreign('sale_id')
                ->references('id')
                ->on('persons')
                ->onDelete('cascade');
            $table->string('invoice_number');
            $table->string('invoice_type')->comment('orders,purchase');
            $table->string('payment_type')->comment('cash,not cash,bank');
            $table->double('total');
            $table->double('paid');
            $table->double('due');
            $table->double('tax')->default(0);
            $table->double('discount')->default(0);
            $table->double('discount_type')->default(0);
            $table->text('note')->nullable();
            $table->string('status')->default(1);
            $table->integer('bank_id')->nullable()->default(1);
            $table->json('meta')->nullable();
            $table->date('invoice_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('order_detailes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->unsignedInteger('store_id');
            $table->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->onDelete('cascade');
            $table->string('store_name')->nullable();
            $table->string('unit_name')->nullable();
            $table->string('product_name')->nullable();
            $table->string('serial_number')->nullable();
            $table->date('expiration_date')->nullable();
            $table->unsignedInteger('unit_id');
            $table->foreign('unit_id')
                ->references('id')
                ->on('units')
                ->onDelete('cascade');
            $table->integer('qty');
            $table->double('cost');
            $table->double('price')->nullable();
            $table->double('total');
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
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_detailes');
    }
}
