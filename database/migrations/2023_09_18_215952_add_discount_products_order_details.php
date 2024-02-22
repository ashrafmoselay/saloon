<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiscountProductsOrderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_detailes', function (Blueprint $table) {
            $table->double('discount1')->nullable();
            $table->double('discount2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_detailes', function (Blueprint $table) {
            $table->dropColumn('discount1', 'discount2');
        });
    }
}