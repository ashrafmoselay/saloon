<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('creator_id')->nullable();
            $table->unsignedInteger('client_id');
            $table->foreign('client_id')
                ->references('id')
                ->on('persons')
                ->onDelete('cascade');
            $table->string('priceType')->default('multi')->nullable();
            $table->double('discount_value')->default(0);
            $table->double('tax_value')->default(0);
            $table->string('invoice_number')->nullable();
            $table->double('total')->nullable();
            $table->double('paid')->nullable();
            $table->double('due')->nullable();
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
        Schema::create('offer_detailes', function (Blueprint $table) {
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
            $table->unsignedInteger('store_id')->nullable();
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
        Schema::dropIfExists('offer_detailes');
        Schema::dropIfExists('offers');

    }
}