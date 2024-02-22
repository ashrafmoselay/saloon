<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFirstQtyProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('first_qty')->default('0');
        });
        foreach (\App\Product::get() as $product){
            $orders =  $product->orders()->sum('qty');
            $purchases =  $product->purchases()->sum('qty');
            $ordersreturn =  $product->ordersreturn()->sum('qty');
            $purchasesreturn =  $product->purchasesreturn()->sum('qty');
            $final = ($purchases + $ordersreturn) - ($orders+$purchasesreturn);
            $product->first_qty = abs($final);
            $product->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('first_qty');
        });
    }
}
