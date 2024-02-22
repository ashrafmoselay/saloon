<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderReturn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->double('total_return')->nullable()->default(0);
        });
        Schema::table('order_detailes', function (Blueprint $table) {
            $table->double('return_qty')->nullable()->default(0);
        });
        Schema::table('returns', function (Blueprint $table) {
            $table->unsignedInteger('order_id')->nullable()->default(0);
        });


        $list = \App\Order::where('invoice_type','sales')
            //->whereNotNull('discount')
            ->get();
        if($list){
            foreach ($list as $order){
                $order->profit =  $order->order_profit;
                $order->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('total_return');
        });
        Schema::table('order_detailes', function (Blueprint $table) {
            $table->dropColumn('return_qty');
        });
        Schema::table('returns', function (Blueprint $table) {
            $table->dropColumn('order_id');
        });
    }
}
