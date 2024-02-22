<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('settings')->insert([
            [ 'key' => 'show_shipment_company', 'name' =>'Show Shipment Company', 'value'=>'0'],
            [ 'key' => 'show_all_products_returns', 'name' =>'Show All Products In Returns', 'value'=>'0']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('settings')->wherein('key',
            [
            'show_shipment_company',
            'show_all_products_returns'
            ]
        )->delete();
    }
}
