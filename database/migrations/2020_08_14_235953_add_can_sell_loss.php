<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCanSellLoss extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Setting::firstOrCreate([
            'key' => 'can_sell_loss'
        ],[ 'key' => 'can_sell_loss', 'name' =>'can_sell_loss', 'value'=>2]);
        \App\Setting::firstOrCreate([
            'key' => 'enable_edit_date'
        ],[ 'key' => 'enable_edit_date', 'name' =>'enable_edit_date', 'value'=>1]);
        \App\Setting::firstOrCreate([
            'key' => 'enable_empty_invoice'
        ],[ 'key' => 'enable_empty_invoice', 'name' =>'enable_empty_invoice', 'value'=>1]);
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
