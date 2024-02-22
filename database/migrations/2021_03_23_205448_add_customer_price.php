<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCustomerPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_unit', function (Blueprint $table) {
            $table->double('customer_price')->after('gomla_price')->nullable();
        });
        Schema::table('order_detailes', function (Blueprint $table) {
            $table->double('customer_price')->after('price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_unit', function (Blueprint $table) {
            $table->dropColumn('customer_price');
        });
        Schema::table('order_detailes', function (Blueprint $table) {
            $table->dropColumn('customer_price');
        });
    }
}
