<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFollowupmobile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipment_detailes', function (Blueprint $table) {
            $table->integer('returned_qty')->default(0)->change();
            $table->string('color')->nullable()->after('product_id');
        });
        Schema::table('shipments', function (Blueprint $table) {
            $table->string('follow_up_mobile')->nullable()->after('shipping_status');
            $table->string('note')->nullable()->after('shipping_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipment_detailes', function (Blueprint $table) {
            $table->dropColumn('color');
        });
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn(['follow_up_mobile','note']);
        });
    }
}
