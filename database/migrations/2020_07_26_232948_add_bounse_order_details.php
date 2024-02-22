<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBounseOrderDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('order_detailes', function (Blueprint $table) {
            $table->integer('bounse')->nullable();
            $table->integer('bounse_unit_id')->nullable();
            $table->string('bounseUnitText')->nullable();
        });
        DB::table('settings')->insert([
            [ 'key' => 'use_bounse', 'name' =>'use_bounse', 'value'=>1]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_detailes', function (Blueprint $table) {
            $table->dropColumn(['bounse','bounse_unit_id','bounseUnitText']);
        });
    }
}
