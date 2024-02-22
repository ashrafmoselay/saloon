<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->String('name')->nullable();
            $table->string('key')->unique();
            $table->string('value')->nullable();
            $table->timestamps();
        });
        DB::table('settings')->insert([
            [ 'key' => 'SiteName', 'name' =>'Site Name', 'value'=>''],
            [ 'key' => 'Address', 'name' =>'Address', 'value'=>''],
            [ 'key' => 'mobile', 'name' =>'mobile', 'value'=>''],
            [ 'key' => 'show_cost_price', 'name' =>'show_cost_price', 'value'=>'1'],
            [ 'key' => 'canChangePrice', 'name' =>'canChangePrice', 'value'=>'1'],
            [ 'key' => 'productCost', 'name' =>'productCost', 'value'=>'avg'],
            [ 'key' => 'showImage', 'name' =>'showImage', 'value'=>'2'],
            [ 'key' => 'show_profit_button', 'name' =>'show_profit_button', 'value'=>'1'],
            [ 'key' => 'can_order_unavilable_qty', 'name' =>'can_order_unavilable_qty', 'value'=>'2'],
            [ 'key' => 'sales_marketer', 'name' =>'sales_marketer', 'value'=>'2'],
            [ 'key' => 'industrial', 'name' =>'industrial', 'value'=>'1'],
            [ 'key' => 'show_category_in_invoice', 'name' =>'show_category_in_invoice', 'value'=>'2'],
            [ 'key' => 'show_stores_in_invoices', 'name' =>'show_stores_in_invoices', 'value'=>'2'],
            [ 'key' => 'PrintSize', 'name' =>'PrintSize', 'value'=>'12'],
            [ 'key' => 'onlineurl', 'name' =>'onlineurl', 'value'=>'']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
