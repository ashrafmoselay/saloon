<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChekOrdersTotal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            $list = \App\Order::where('invoice_type', 'sales')
                ->whereRaw("DATE(invoice_date) >= '2023-09-01'")
                ->get();
            if ($list) {
                foreach ($list as $order) {
                    $totalDetails = $order->total_sale;
                    $discount = $order->discount ?: 0;
                    if ($discount) {
                        if ($order->discount_type == 2) {
                            $discount = $totalDetails * ($discount / 100);
                        }
                    }
                    $totalDetails -= $discount;
                    if ($order->tax) {
                        $tax = $order->tax / 100;
                        $totalDetails += ($totalDetails * $tax);
                    }
                    $order->total = $totalDetails;
                    if ($order->due == 0) {
                        $order->paid = $totalDetails;
                    }
                    $order->save();
                }
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}