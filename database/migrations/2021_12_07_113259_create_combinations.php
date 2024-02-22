<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCombinations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combinations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
        Schema::create('product_combinations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('combination_id');
            $table->unsignedBigInteger('store_id');
            $table->integer('qty');
            $table->integer('sale_counter')->nullable()->default(0);
            $table->timestamps();
        });
        Schema::table('shipment_detailes', function (Blueprint $table) {
            $table->unsignedBigInteger('combination_id')->after('product_id')->nullable();
        });
        $list = $this->getCombinations(
            array('ابيض', 'اسود', 'رمادي','كحلي','بيج','اوف وايت','سكرى','هافان','كشمير','عنابى','زيتي','زهرى غامق','رمادى فاتح'),
            array('S','M','L','XL','XXL','3XL','4XL','اوفر سايز')
        );
        foreach ($list as $com){
            $a = implode(' - ',$com);
            \Illuminate\Support\Facades\DB::table('combinations')->insert([
                'title'=>$a
            ]);
        }
        DB::table('settings')->insert([
            [ 'key' => 'use_color_size_qty', 'name' =>'Use Combination Qty', 'value'=>'0'],
            [ 'key' => 'use_two_shipping_cost', 'name' =>'Use Two Shipping Cost', 'value'=>'0'],
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
            'use_color_size_qty',
            'use_two_shipping_cost'
            ]
        )->delete();
        Schema::dropIfExists('product_combinations');
        Schema::dropIfExists('combinations');
        Schema::table('shipment_detailes', function (Blueprint $table) {
            $table->dropColumn('combination_id');
        });
    }


    function getCombinations(...$arrays)
    {
        $result = [[]];
        foreach ($arrays as $property => $property_values) {
            $tmp = [];
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, [$property => $property_value]);
                }
            }
            $result = $tmp;
        }
        return $result;
    }
}
